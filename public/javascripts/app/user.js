window.addEvent('domready',function(){
	
	var swapsenha = $('swapsenha');
	var txtsenha = $('txtsenha');
	
	if(swapsenha!=null){
		swapsenha.addEvent('click', function(){
			txtsenha.set('disabled',!swapsenha.getProperty('checked'));
		});
	}
	
});