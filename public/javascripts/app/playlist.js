window.addEvent('domready',function(){	
	var frontlineYouTube=new videoYT({orderby:"viewCount",maxResults:50,container: 'listaVideos'});
	frontlineYouTube.callLista(playlista);
	
	dbug.log(playlista);
});
