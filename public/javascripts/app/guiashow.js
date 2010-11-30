window.addEvent('load',function(){
	jQuery('img.graph').each(function(idx,el){
		var p=el.get('alt');
		var c=((p*213)/100)-210;
		//
		el.set('tween',{duration:2000,transition:Fx.Transitions.Cubic.easeIn});
		el.tween('background-position','-213px 0',c+'px 0');
	});
	
});

window.addEvent('domready',function(){
	jQuery("input.fecharForm:button").live("click",function(e){
		jQuery.fancybox.close();
	});
	//
    jQuery("a.envie").fancybox({
		'modal':true,
		'scrolling':'no',
		'margin':0,
		'padding':0,
		'opacity':true,
		'width':520
    });
});