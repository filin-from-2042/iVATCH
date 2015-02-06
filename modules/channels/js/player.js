navigator.getUserMedia = navigator.getUserMedia || navigator.mozGetUserMedia || navigator.webkitGetUserMedia;
navigator.getUserMedia({ audio: true, video: false }, gotStream, streamError);

function gotStream(stream) {
    document.querySelector('video').src = URL.createObjectURL(stream);
	document.getElementById("callButton").style.display = 'inline-block';
	document.getElementById("localVideo").src = URL.createObjectURL(stream);

	pc = new PeerConnection(null);
	pc.addStream(stream);
	pc.onicecandidate = gotIceCandidate;
	pc.onaddstream = gotRemoteStream;
}

function streamError(error) {
    console.log(error);
}

function createOffer() {
	pc.createOffer(
		gotLocalDescription,
		function(error) { console.log(error) },
		{ 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
	);
}

function createAnswer() {
	pc.createAnswer(
		gotLocalDescription,
		function(error) { console.log(error) },
		{ 'mandatory': { 'OfferToReceiveAudio': true, 'OfferToReceiveVideo': true } }
	);
}

function gotIceCandidate(event){
	if (event.candidate) {
		sendMessage({
			type: 'candidate',
			label: event.candidate.sdpMLineIndex,
			id: event.candidate.sdpMid,
			candidate: event.candidate.candidate
		});
	}
}