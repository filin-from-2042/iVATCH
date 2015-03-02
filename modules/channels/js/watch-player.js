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

    var pc_constraints = {'optional': [{'DtlsSrtpKeyAgreement': true}]};

    // Set up audio and video regardless of what devices are present.
    var sdpConstraints = {'mandatory': {
        'OfferToReceiveAudio':true,
        'OfferToReceiveVideo':true }};

    /////////////////////////////////////////////

    var room = '';
//    var socket = io.connect('ivatch-signaling.herokuapp.com');
    var socket = io.connect('localhost:1234');

    room = prompt("Enter room name:");

    if (room !== "") {
        console.log('Joining room ' + room);
        socket.emit('join', room);
    }
    else return false;



    sendMessage('got user media');

    /*EVENT LISTENERS*/
    socket.on('joined',
        function(room)
        {
            console.log('This peer has joined room ' + room);
        }
    );

    /*FUNCTIONS*/
    function sendMessage(message){
        console.log('Client sending message: ', message);
        // if (typeof message === 'object') {
        //   message = JSON.stringify(message);
        // }
        socket.emit('message', message);
    }

});