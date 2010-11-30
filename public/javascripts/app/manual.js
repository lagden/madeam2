var manualFx;
//window.addEvent('domready', function(){
window.addEvent('load', function(){
 
	var mf = new MooFlow($('MooFlow'), {
		startIndex: 0,
		useSlider: false,
		useAutoPlay: false,
		useCaption: false,
		useResize: false,
		useWindowResize: false,
		useMouseWheel: false,
		useKeyInput: false,
		useViewer:false,
		bgColor:'#FFF',
		heightRatio:.25,
		offsetY:-200,
		onClickView: function(obj){
			getAjax({'conteudo':jQuery(obj).attr('alt')});
		},
		onStart:function(){
			mf.viewCallBack(0);
		}
	});
	
	//mf.fireEvent('onClickView');
	manualFx = new Fx.Tween('manualContent',{duration: 1000});
});

function getAjax(dados){
	var ajax=new Request.HTML({
		url: baseUrl+'index/conteudo/',
		data: dados,
		noCache: true,
		onRequest:function(){
			//$('loadingCalendar').addClass('loadingShow');
			manualFx.set('opacity',0);
		},
		onSuccess:function(responseTree, responseElements, responseHTML, responseJavaScript){
			//$('loadingCalendar').removeClass('loadingShow');
			manualFx.start('opacity',0,1);
			jQuery('div#manualContent').html(responseHTML);
		}
	}).get();
}