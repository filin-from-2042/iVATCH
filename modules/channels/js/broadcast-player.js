$(document).ready(function(){
    'use strict';

    navigator.getUserMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);


    var pc_config = {'iceServers': [
        {'url': 'stun:stun.l.google.com:19302'},
        {url:'stun:stun01.sipphone.com'},
        {url:'stun:stun.ekiga.net'},
        {url:'stun:stun.fwdnet.net'},
        {url:'stun:stun.ideasip.com'},
        {url:'stun:stun.iptel.org'},
        {url:'stun:stun.rixtelecom.se'},
        {url:'stun:stun.schlund.de'},
        {url:'stun:stun.l.google.com:19302'},
        {url:'stun:stun1.l.google.com:19302'},
        {url:'stun:stun2.l.google.com:19302'},
        {url:'stun:stun3.l.google.com:19302'},
        {url:'stun:stun4.l.google.com:19302'},
        {url:'stun:stunserver.org'},
        {url:'stun:stun.softjoys.com'},
        {url:'stun:stun.voiparound.com'},
        {url:'stun:stun.voipbuster.com'},
        {url:'stun:stun.voipstunt.com'},
        {url:'stun:stun.voxgratia.org'},
        {url:'stun:stun.xten.com'},
        {
            url: 'turn:numb.viagenie.ca',
            credential: 'muazkh',
            username: 'webrtc@live.com'
        },
        {
            url: 'turn:192.158.29.39:3478?transport=udp',
            credential: 'JZEOEt2V3Qb0y27GRntt2u2PAYA=',
            username: '28224511:1379330808'
        },
        {
            url: 'turn:192.158.29.39:3478?transport=tcp',
            credential: 'JZEOEt2V3Qb0y27GRntt2u2PAYA=',
            username: '28224511:1379330808'
        }
    ]};

	var broadcasting = {};
    broadcasting.constraints = {video: true};
    broadcasting.pc_constraints = {'optional': [{'DtlsSrtpKeyAgreement': true}]};

    // Set up audio and video regardless of what devices are present.
    broadcasting.sdpConstraints = {'mandatory': {
        'OfferToReceiveAudio':true,
        'OfferToReceiveVideo':true }
	};

    /////////////////////////////////////////////

    var room = '';
    var pc;
    broadcasting.aConnections = [];
    var remoteStream;
//    var socket = io.connect('ivatch-signaling.herokuapp.com');
    var socket = io.connect('192.168.0.3:1234');

    room = prompt("Enter room name:");

    if (room !== "")
	{
        console.log('Creating room ' + room);
        socket.emit('create', room);
    }

    navigator.getUserMedia(broadcasting.constraints, successCallback, errorCallback);

    /*EVENT LISTENERS*/
    socket.on('created',
        function(room)
        {
            console.log('Created room ' + room);
        }
    );

    socket.on('message',
        function(message)
        {
			if (message.type === 'got user media')
			{
            	Start(message.user_id);
			}
			else if (message.type === 'answer')
			{
				broadcasting.aConnections[message.user_id].setRemoteDescription(new RTCSessionDescription(message.sessionDescription));
			}
			else if (message.type === 'candidate')
			{
				var candidate = new RTCIceCandidate({
					sdpMLineIndex: message.label,
					candidate: message.candidate
				});
                broadcasting.aConnections[message.user_id].addIceCandidate(candidate);
			}
			else if (message.type === 'bye')
			{
				console.log(broadcasting.aConnections);
				if(broadcasting.aConnections[message.user_id]) { broadcasting.aConnections[message.user_id].close(); broadcasting.aConnections[message.user_id] = null; }
			}
        }
    );

    socket.on('join',
        function(room)
        {
            console.log('This peer has joined room ' + room);
        }
    );

    /*FUNCTIONS*/
    function Start(user_id) {
            createPeerConnection(user_id);
            broadcasting.aConnections[user_id].addStream(window.stream);
            doCall(user_id);
    }

    function createPeerConnection(user_id) {
        try {
            broadcasting.aConnections[user_id] = new RTCPeerConnection(null);
            broadcasting.aConnections[user_id].onicecandidate =
                function (event) {
                    console.log('handleIceCandidate event: ', event);
                    if (event.candidate) {
                        sendMessage(
							{
								type: 'candidate',
								label: event.candidate.sdpMLineIndex,
								id: event.candidate.sdpMid,
								candidate: event.candidate.candidate,
								user_id:user_id
							}
                        );
                    } else {
                        console.log('End of candidates.');
                    }
                };
            broadcasting.aConnections[user_id].onaddstream = handleRemoteStreamAdded;
            broadcasting.aConnections[user_id].onremovestream = handleRemoteStreamRemoved;
            console.log('Created RTCPeerConnnection');
        } catch (e) {
            console.log('Failed to create PeerConnection, exception: ' + e.message);
            alert('Cannot create RTCPeerConnection object.');
            return;
        }
    }

    function doCall(user_id) {
        console.log('Sending offer to peer');
        broadcasting.aConnections[user_id].createOffer(
            function (sessionDescription)
            {
                // Set Opus as the preferred codec in SDP if Opus is present.
                sessionDescription.sdp = preferOpus(sessionDescription.sdp);
                broadcasting.aConnections[user_id].setLocalDescription(sessionDescription);
                console.log('setLocalAndSendMessage sending message' , sessionDescription);
                sessionDescription.user_id = user_id;
				var message = {user_id:user_id,sessionDescription:sessionDescription,type :'offer'};
                sendMessage(message);
            },
            function (event)
            {
                console.log('createOffer() error: ', e);
            }
        );
    }

    function sendMessage(message){
        console.log('Client sending message: ', message);
        // if (typeof message === 'object') {
        //   message = JSON.stringify(message);
        // }
        socket.emit('message', message);
    }


    function successCallback(localMediaStream) {
        window.stream = localMediaStream; // stream available to console
//        var video = document.querySelector("video");
//        video.src = window.URL.createObjectURL(localMediaStream);
//        video.play();
    }

    function errorCallback(error){
        console.log("navigator.getUserMedia error: ", error);
    }



    function handleRemoteStreamAdded(event) {
        console.log('Remote stream added.');
        remoteVideo.src = window.URL.createObjectURL(event.stream);
        remoteStream = event.stream;
    }

    function handleRemoteStreamRemoved(event) {
        console.log('Remote stream removed. Event: ', event);
    }


    /*---------------------------------------------------- CODEC INIT FUNCTION ----------------------------------------*/

    // Set Opus as the default audio codec if it's present.
    function preferOpus(sdp) {
        var sdpLines = sdp.split('\r\n');
        var mLineIndex;
        // Search for m line.
        for (var i = 0; i < sdpLines.length; i++) {
            if (sdpLines[i].search('m=audio') !== -1) {
                mLineIndex = i;
                break;
            }
        }
        if (!mLineIndex ) {
            return sdp;
        }

        // If Opus is available, set it as the default in m line.
        for (i = 0; i < sdpLines.length; i++) {
            if (sdpLines[i].search('opus/48000') !== -1) {
                var opusPayload = extractSdp(sdpLines[i], /:(\d+) opus\/48000/i);
                if (opusPayload) {
                    sdpLines[mLineIndex] = setDefaultCodec(sdpLines[mLineIndex], opusPayload);
                }
                break;
            }
        }

        // Remove CN in m line and sdp.
        sdpLines = removeCN(sdpLines, mLineIndex);

        sdp = sdpLines.join('\r\n');
        return sdp;
    }

    function extractSdp(sdpLine, pattern) {
        var result = sdpLine.match(pattern);
        return result && result.length === 2 ? result[1] : null;
    }

    // Set the selected codec to the first in m line.
    function setDefaultCodec(mLine, payload) {
        var elements = mLine.split(' ');
        var newLine = [];
        var index = 0;
        for (var i = 0; i < elements.length; i++) {
            if (index === 3) { // Format of media starts from the fourth.
                newLine[index++] = payload; // Put target payload to the first.
            }
            if (elements[i] !== payload) {
                newLine[index++] = elements[i];
            }
        }
        return newLine.join(' ');
    }

    // Strip CN from sdp before CN constraints is ready.
    function removeCN(sdpLines, mLineIndex) {
        var mLineElements = sdpLines[mLineIndex].split(' ');
        // Scan from end for the convenience of removing an item.
        for (var i = sdpLines.length-1; i >= 0; i--) {
            var payload = extractSdp(sdpLines[i], /a=rtpmap:(\d+) CN\/\d+/i);
            if (payload) {
                var cnPos = mLineElements.indexOf(payload);
                if (cnPos !== -1) {
                    // Remove CN payload from m line.
                    mLineElements.splice(cnPos, 1);
                }
                // Remove CN line in sdp
                sdpLines.splice(i, 1);
            }
        }

        sdpLines[mLineIndex] = mLineElements.join(' ');
        return sdpLines;
    }



});