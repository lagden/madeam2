window.addEvent('domready',function(){	
	var frontlineYouTubeVistos=new videoYT({orderby:"viewCount",maxResults:4,container: 'maisvistosVideos'});
	frontlineYouTubeVistos.getDados();
});
