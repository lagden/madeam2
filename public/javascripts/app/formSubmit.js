var formCheck;
window.addEvent('domready',function(){
	
	if(typeof formID != 'undefined'){
		formCheck=new FormCheck(formID,{
			submit:true,
			submitByAjax:false
		});
	}
	
	var voltaBtn = $('voltaBtn');
	
	if(voltaBtn!=null){
		voltaBtn.addEvent('click', function(){
			var page=Cookie.read('page');
			location=path+'/page/'+page+'/'+reg;
		});
	}
	
});
