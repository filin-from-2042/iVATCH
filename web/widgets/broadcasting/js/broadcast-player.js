/**
 * Created by Set on 08.03.15.
 */


'use strict';
var broadcasting = function()
{
    var config = {
            constraints : {video: true},
            pc_constraints : {'optional': [{'DtlsSrtpKeyAgreement': true}]},
            signaling_host :'localhost:1234',
            sdpConstraints : {'mandatory': {
                                            'OfferToReceiveAudio':true,
                                            'OfferToReceiveVideo':true
                                            }
                            },
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
                    }
        };
    var stream,
        socket;
    var aWatchers = [];

    /*------------------------------------------------------- CREATED HANDLER ----------------------------------------*/
    /**
     * Function handling 'created' event
     */
    var createdHandler = function()
    {
        console.log('Created room ' + broadcasting.room);
    };

    /*---------------------------------------------------- MESSAGE HANDLER -------------------------------------------*/
    /**
     * Function handling 'message' event
     * @param message
     */
    var messageHandler = function(message)
    {
        if (message.type === 'got user media')
        {
            broadcasting.addWatcher(message.watcher_id);
        }
        else if (message.type === 'answer')
        {
            broadcasting.aWatchers[message.watcher_id].setRemoteDescription(new RTCSessionDescription(message.sessionDescription));
        }
        else if (message.type === 'candidate')
        {
            var candidate = new RTCIceCandidate({
                sdpMLineIndex: message.label,
                candidate: message.candidate
            });
            broadcasting.aWatchers[message.watcher_id].addIceCandidate(candidate);
        }
        else if (message.type === 'bye')
        {
            console.log('Peer has left room');
            if(broadcasting.aWatchers[message.watcher_id])
            { 
                broadcasting.aWatchers[message.watcher_id].close();
                broadcasting.aWatchers[message.watcher_id] = null;
            }
        }
    };
    
    /*-------------------------------------------------------- JOIN HANDLER ------------------------------------------*/
    /**
     * Function handling 'join' event 
     */
    var joinHandler = function()
    {
        console.log('User joined room ' + broadcasting.room);
    };


    /*------------------------------------------------------- ADD WATCHER --------------------------------------------*/
    /**
     * Function adding watcher
     * @param watcher_id - watcher id
     */
    var addWatcher = function(watcher_id)
    {
        broadcasting.createPeerConnection(watcher_id);
        broadcasting.aWatchers[watcher_id].addStream(broadcasting.stream);
        broadcasting.sendDescription(watcher_id);
    };


    /*---------------------------------------------------- CREATE PEER CONNECTION ------------------------------------*/
    /**
     * Function creating peer connection and adding event handlers for created connection
     * @param watcher_id
     */
    var createPeerConnection = function (watcher_id)
    {
        try {
            broadcasting.aWatchers[watcher_id] = new RTCPeerConnection(null);
            broadcasting.aWatchers[watcher_id].onicecandidate =
                function (event) {
                    console.log('handleIceCandidate event: ', event);
                    if (event.candidate) {
                        broadcasting.sendMessage(
                                                    {
                                                        type: 'candidate',
                                                        label: event.candidate.sdpMLineIndex,
                                                        id: event.candidate.sdpMid,
                                                        candidate: event.candidate.candidate,
                                                        watcher_id:watcher_id
                                                    }
                                                );
                    } else {
                        console.log('End of candidates.');
                    }
                };
            console.log('Created RTCPeerConnnection');
        } catch (e) {
            console.log('Failed to create PeerConnection, exception: ' + e.message);
            alert('Cannot create RTCPeerConnection object.');
            return;
        }
    };


    /*------------------------------------------------------ SEND OFFER ----------------------------------------------*/
    /**
     * Function sending broadcaster description to watcher
     * @param watcher_id - watcher id, which will be send description
     */
    var sendDescription = function(watcher_id)
    {
        console.log('Sending offer to peer');
        broadcasting.aWatchers[watcher_id].createOffer(
            function (sessionDescription)
            {
                // Set Opus as the preferred codec in SDP if Opus is present.
                sessionDescription.sdp = preferOpus(sessionDescription.sdp);
                broadcasting.aWatchers[watcher_id].setLocalDescription(sessionDescription);
                console.log('setLocalAndSendMessage sending message' , sessionDescription);
                sessionDescription.watcher_id = watcher_id;
                var message = {
                                watcher_id:watcher_id,
                                sessionDescription:sessionDescription,
                                type :'offer'
                                };
                broadcasting.sendMessage(message);
            },
            function (event)
            {
                console.log('createOffer() error: ', e);
            }
        );
    };


    /*-------------------------------------------------------- SEND MESSAGE ------------------------------------------*/
    /**
     * Function sending message in room
     * @param message - message for sending
     */
    var sendMessage = function(message)
    {
        console.log('Client sending message: ', message);
        broadcasting.socket.emit('message', message);
    };


    /*-------------------------------------------------------- MEDIA SUCCESS HANDLER ---------------------------------*/
    /**
     * Function handling getUserMedia success event
     * @param localMediaStream - gotten media stream
     */
    var mediaSuccessHandler = function(localMediaStream)
    {
        broadcasting.stream = localMediaStream; // stream available to console
//        var video = document.querySelector("video");
//        video.src = window.URL.createObjectURL(localMediaStream);
//        video.play();
    };


    /*---------------------------------------------------- MEDIA ERROR HANDLER ---------------------------------------*/
    /**
     * Function handling getUserMedia success event
     * @param error - error text
     */
    var mediaErrorHandler = function (error)
    {
        console.log("navigator.getUserMedia error: ", error);
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
                var opusPayload = broadcasting.extractSdp(sdpLines[i], /:(\d+) opus\/48000/i);
                if (opusPayload)
                {
                    sdpLines[mLineIndex] = broadcasting.setDefaultCodec(sdpLines[mLineIndex], opusPayload);
                }
                break;
            }
        }

        // Remove CN in m line and sdp.
        sdpLines = broadcasting.removeCN(sdpLines, mLineIndex);

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
            var payload = broadcasting.extractSdp(sdpLines[i], /a=rtpmap:(\d+) CN\/\d+/i);
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
        stream:stream,
        socket:socket,
        aWatchers:aWatchers,
        config:config,
        createdHandler:createdHandler,
        messageHandler:messageHandler,
        joinHandler:joinHandler,
        addWatcher:addWatcher,
        createPeerConnection:createPeerConnection,
        sendDescription:sendDescription,
        sendMessage:sendMessage,
        mediaSuccessHandler:mediaSuccessHandler,
        mediaErrorHandler:mediaErrorHandler,
        preferOpus:preferOpus,
        extractSdp:extractSdp,
        setDefaultCodec:setDefaultCodec,
        removeCN:removeCN
    };

}();

$(document).ready(function()
{
    navigator.getUserMedia = ( navigator.getUserMedia ||
        navigator.webkitGetUserMedia ||
        navigator.mozGetUserMedia ||
        navigator.msGetUserMedia);

    broadcasting.socket = io.connect('localhost:1234');
    broadcasting.room = prompt("Enter room name:");


    if (broadcasting.room !== "")
    {
        console.log('Creating room ' + broadcasting.room);
        broadcasting.socket.emit('create', broadcasting.room);
    }

    navigator.getUserMedia(broadcasting.config.constraints, broadcasting.mediaSuccessHandler, broadcasting.mediaErrorHandler);


    broadcasting.socket.on('created',broadcasting.createdHandler);

    broadcasting.socket.on('message',broadcasting.messageHandler);

    broadcasting.socket.on('join',broadcasting.joinHandler);

});