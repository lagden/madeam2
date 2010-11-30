window.addEvent('domready',function(){
	loadPlayer(videoID,"YouTubePlayer");
});

function loadPlayer(vId,divId){
	var params = { allowScriptAccess: "always" };
	var atts = { id: divId };
	swfobject.embedSWF("http://www.youtube.com/v/" + vId + "&enablejsapi=1&playerapiid=player1", divId, "560", "340", "8", null, null, params, atts);
}
