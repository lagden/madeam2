window.addEvent('domready',function(){
	
	var opts={submit:false,submitByAjax:true};
	
	new FormCheck('formLogin',$extend(opts,{onAjaxSuccess:loginResponse}));
	new FormCheck('formRecupera',$extend(opts,{onAjaxSuccess:recuperaResponse}));
	
	Element.implement({
		tween: function(property, from, to){
			this.get('tween').start(arguments);
			return this;
		},
		fade: function(how){
			var fade = this.get('tween'), o = 'opacity', toggle;
			how = $pick(how,'toggle');
			switch (how){
			case 'in': fade.start(o, 1); break;
			case 'out': fade.start(o, 0); break;
			case 'show': fade.set(o, 1); break;
			case 'hide': fade.set(o, 0); break;
			case 'toggle':
			var flag = this.retrieve('fade:flag', this.get('opacity') == 1);
			fade.start(o, (flag) ? 0 : 1);
			this.store('fade:flag', !flag);
			toggle = true;
			break;
			default: fade.start(o, arguments);
			}
			if (!toggle) this.eliminate('fade:flag');
			return this;
		},
		move: function(pos){
			pos = $pick(pos,'center');
			this.get('move').start({position:pos});
			return this;
		}
	});
	
	var esqueceuAtivo=false;
	
	$('loginFrm').position().setStyles({"opacity":0}).fade('in');
	$('esqueceuFrm').fade('hide');
	
	window.addEvent('resize',function(){
		$('loginFrm').position();
		if(esqueceuAtivo)$('esqueceuFrm').position();
	});
	
	$('voltaLoginBtn').addEvent('click', function(msg){
		$('loginFrm').fade('in');
		$('esqueceuFrm').fade('out').move('upperLeft');
		clearTips();
		esqueceuAtivo=false;
	});
	
	$('recuperaLnk').addEvent('click', function(){
		$('loginFrm').fade('out');
		$('esqueceuFrm').fade('in').move();
		clearTips();
		esqueceuAtivo=true;
	});
	
});

function clearTips(){
	$$('div.fc-tbx').fade('out');
}

function loginResponse(response){
	var object=JSON.decode(response,true);
	if(object!=null){
		if(object.ok){
			location=object.path;
		}else alert(object.msg);
	}else alert('Erro na resposta!');
}

function recuperaResponse(response){
	var object=JSON.decode(response,true);
	if(object!=null){
		if(object.ok){
			$('recuperaEmail').set('value','');
			$('voltaLoginBtn').fireEvent('click');
		}else alert(object.msg);
	}else alert('Erro na resposta!');
}