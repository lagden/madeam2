window.addEvent('domready',function(){
	
	var buttonPages = $$('button.paginacao');
	
	if(buttonPages!=null){
		buttonPages.each(function(item, index){
			$(item).addEvent('click', function(){
				var page=$(this).getProperty('pagina');
				location=path+'page/'+page;
			});
		});
	}
	
});