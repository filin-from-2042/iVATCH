/**
 * Created by Expert04 on 06.03.15.
 */

watching = function(){
	var config = {
            remoteVideo:'#remoteVideo',
			pc_config : {'iceServers': [
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
						]
			},
			sdpConstraints : {'mandatory': {
										'OfferToReceiveAudio':true,
										'OfferToReceiveVideo':true
										}
							},
			signaling_host :'localhost:1234'
	};

    var isStarted=false,
        room = null,
        peerConnection = null,
        watcher_id = null

    /*---------------------------------------------------- JOINED CALLBACK -------------------------------------------*/
    /**
     *  Callback function for 'joined' event
     * @param message - message object
     */
    var joinedCallback = function(message)
    {
        console.log('This peer has joined room ' + room);
        watching.watcher_id = this.id;
        watching.sendMessage(
            {
                type:'got user media',
                watcher_id:watching.watcher_id
            }
        );
    };


    /*---------------------------------------------------- JOINED CALLBACK -------------------------------------------*/
    /**
     *  Callback function for 'message' event
     * @param message - message object
     */
    var messageCallback = function(message)
    {
            if(message.watcher_id != watching.watcher_id) return;
            if (message.type === 'offer')
            {
                watching.createPeerConnection();
                console.log('Sending answer to peer.');
                watching.peerConnection.setRemoteDescription(new RTCSessionDescription(message.sessionDescription));
                watching.peerConnection.createAnswer(watching.setLocalAndSendMessage, function(error) {alert(error);}, watching.config.sdpConstraints);
            }
            else if (message.type === 'candidate')
            {
                if(!watching.isStarted) return;
                var candidate = new RTCIceCandidate({
                    sdpMLineIndex: message.label,
                    candidate: message.candidate
                });
                watching.peerConnection.addIceCandidate(candidate);
            }
        };

    /*------------------------------------------------------- SEND MESSAGE -------------------------------------------*/
    /**
     *  Function sending message emitting event 'message'
     * @param message - object with message like sessionDescription, candidate message, bye message etc.
     */
    var sendMessage = function(message)
        {
            message.watcher_id = watching.watcher_id;
            console.log('Client sending message: ', message);
            // if (typeof message === 'object') {
            //   message = JSON.stringify(message);
            // }
            watching.socket.emit('message', message);
        };

    /*---------------------------------------------------- CREATE PEER CONNECTION ------------------------------------*/
    /**
     *  Function creating RTCPeerConnection and adding event handlers onicecandidate, on add stream and onremovestream
     */
    var createPeerConnection = function ()
    {
        try {
            watching.peerConnection = new RTCPeerConnection(null);
            watching.peerConnection.onicecandidate = watching.handleIceCandidate;
            watching.peerConnection.onaddstream = watching.handleRemoteStreamAdded;
            watching.peerConnection.onremovestream = watching.handleRemoteStreamRemoved;
            console.log('Created RTCPeerConnnection');
            watching.isStarted = true;
        } catch (e) {
            console.log('Failed to create PeerConnection, exception: ' + e.message);
            alert('Cannot create RTCPeerConnection object.');
            return;
        }
    };

    /*---------------------------------------------------- SEND LOCAL DESCRIPTION ------------------------------------*/
    /**
     * Function storing local description and sending him to broadcaster
     * @param sessionDescription - object with local description
     */
    var setLocalAndSendMessage = function(sessionDescription)
    {
        // Set Opus as the preferred codec in SDP if Opus is present.
        sessionDescription.sdp = watching.preferOpus(sessionDescription.sdp);
        watching.peerConnection.setLocalDescription(sessionDescription);
        console.log('setLocalAndSendMessage sending message' , sessionDescription);
        sessionDescription = {
            sessionDescription:sessionDescription,
            type:'answer'
        };
        watching.sendMessage(sessionDescription);
    };


    /*---------------------------------------------------- HANDLE REMOTE STREAM --------------------------------------*/
    /**
     * Function callback 'onaddstream' handler RTCPeerConnection object
     * @param event - event object, which contains remote stream
     */
    var handleRemoteStreamAdded = function(event)
    {
        console.log('Remote stream added.');
        var domRemote = document.querySelector(watching.config.remoteVideo);
        domRemote.src = window.URL.createObjectURL(event.stream);
        domRemote.play();
    };


    /*---------------------------------------------------- HANDLE REMOTE STREAM --------------------------------------*/
    /**
     * Function callback 'onremovestream' handler RTCPeerConnection object
     * @param event
     */
    var handleRemoteStreamRemoved = function(event)
    {
        console.log('Remote stream removed. Event: ', event);
    };


    /*---------------------------------------------------- HANDLE ICE CANDIDATE --------------------------------------*/
    /**
     * Function callback 'onicecandidate' handler RTCPeerConnection object
     * @param event
     */
    var handleIceCandidate = function(event)
    {
        console.log('handleIceCandidate event: ', event);
        if (event.candidate)
        {
            watching.sendMessage({
                        type: 'candidate',
                        label: event.candidate.sdpMLineIndex,
                        id: event.candidate.sdpMid,
                        candidate: event.candidate.candidate,
                        watcher_id:watching.watcher_id
                    });
        }
        else
        {
            console.log('End of candidates.');
        }
    };

    /*----------------------------------------------------- PREFER OPUS ----------------------------------------------*/
    /**
     * Function setting Opus as the default audio codec if it's present.
     * @param sdp
     * @returns {*}
     */
    var preferOpus = function(sdp)
    {
        var sdpLines = sdp.split('\r\n');
        var mLineIndex;
        // Search for m line.
        for (var i = 0; i < sdpLines.length; i++)
        {
            if (sdpLines[i].search('m=audio') !== -1)
            {
                mLineIndex = i;
                break;
            }
        }
        if (!mLineIndex )
        {
            return sdp;
        }

        // If Opus is available, set it as the default in m line.
        for (i = 0; i < sdpLines.length; i++)
        {
            if (sdpLines[i].search('opus/48000') !== -1)
            {
                var opusPayload = watching.extractSdp(sdpLines[i], /:(\d+) opus\/48000/i);
                if (opusPayload)
                {
                    sdpLines[mLineIndex] = watching.setDefaultCodec(sdpLines[mLineIndex], opusPayload);
                }
                break;
            }
        }

        // Remove CN in m line and sdp.
        sdpLines = watching.removeCN(sdpLines, mLineIndex);

        sdp = sdpLines.join('\r\n');
        return sdp;
    };


    /*------------------------------------------------------- EXTRACT SDP --------------------------------------------*/
    /**
     * Function extracting from sdp line needed data by regexp pattern
     * @param sdpLine - line with sdp data
     * @param pattern - regexp pattern for extracting
     * @returns {*}
     */
    var extractSdp = function(sdpLine, pattern)
    {
        var result = sdpLine.match(pattern);
        return result && result.length === 2 ? result[1] : null;
    };


    /*---------------------------------------------------- SET DEFAULT CODEC -----------------------------------------*/
    /**
     * Function setting the selected codec to the first in m line.
     * @param mLine
     * @param payload
     * @returns {string}
     */
    var setDefaultCodec = function(mLine, payload)
    {
        var elements = mLine.split(' ');
        var newLine = [];
        var index = 0;
        for (var i = 0; i < elements.length; i++)
        {
            if (index === 3)
            {
                // Format of media starts from the fourth.
                newLine[index++] = payload; // Put target payload to the first.
            }
            if (elements[i] !== payload)
            {
                newLine[index++] = elements[i];
            }
        }
        return newLine.join(' ');
    };


    /*---------------------------------------------------------- REMOVE CN -------------------------------------------*/
    /**
     * Strip CN from sdp before CN constraints is ready.
     * @param sdpLines
     * @param mLineIndex
     * @returns {*}
     */
    var removeCN = function(sdpLines, mLineIndex)
    {
        var mLineElements = sdpLines[mLineIndex].split(' ');
        // Scan from end for the convenience of removing an item.
        for (var i = sdpLines.length-1; i >= 0; i--)
        {
            var payload = watching.extractSdp(sdpLines[i], /a=rtpmap:(\d+) CN\/\d+/i);
            if (payload)
            {
                var cnPos = mLineElements.indexOf(payload);
                if (cnPos !== -1)
                {
                    // Remove CN payload from m line.
                    mLineElements.splice(cnPos, 1);
                }
                // Remove CN line in sdp
                sdpLines.splice(i, 1);
            }
        }

        sdpLines[mLineIndex] = mLineElements.join(' ');
        return sdpLines;
    };

    return {
        config:config,
        isStarted:isStarted,
        room:room,
        peerConnection:peerConnection,
        watcher_id:watcher_id,
        joinedCallback:joinedCallback,
        messageCallback:messageCallback,
        sendMessage:sendMessage,
        createPeerConnection:createPeerConnection,
        setLocalAndSendMessage:setLocalAndSendMessage,
        handleRemoteStreamAdded:handleRemoteStreamAdded,
        handleRemoteStreamRemoved:handleRemoteStreamRemoved,
        handleIceCandidate:handleIceCandidate,
        preferOpus:preferOpus,
        extractSdp:extractSdp,
        setDefaultCodec:setDefaultCodec,
        removeCN:removeCN
    }

}();

$(document).ready(
    function()
    {
        'use strict';
        navigator.getUserMedia = ( navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mozGetUserMedia ||
            navigator.msGetUserMedia);


        watching.room = 'qwe';
        watching.socket = io.connect(watching.config.signaling_host);

        if (watching.room !== "") {
            console.log('Joining room ' + watching.room);
            watching.socket.emit('join', watching.room);
        }
        else return false;


        watching.socket.on('joined',watching.joinedCallback);

        watching.socket.on('message',watching.messageCallback);

        window.onbeforeunload = function(e){
            watching. sendMessage(
                {
                    type:'bye',
                    user_id:watching.user_id
                }
            );
        };

        return true;
    }
);