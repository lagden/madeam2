window.addEvent('domready',function(){
	
	jQuery('input#_slugTitle:text').stringToSlug({
		getPut:'input#_slugAlias:text'
	});
	
	jQuery('input#_slugAlias:text').stringToSlug({
		getPut:'input#_slugAlias:text',
		setEvents:'blur'
	});
	
});