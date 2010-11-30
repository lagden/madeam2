window.addEvent('domready',function(){
	
	jQuery('.voltarBtn').live('click',function(e){
		var page=Cookie.read('page');
		location=path+'page/'+page;
	});
	
});