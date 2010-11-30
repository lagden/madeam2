window.addEvent('domready',function(){
	
	var limpaBusca = $('limpaBusca');
	
	if(limpaBusca!=null){
		limpaBusca.addEvent('click', function(){
			$('palavraBusca').set('value','');
			$('frmBuscaLista').submit();
		});
	}
	
});