window.addEvent('domready',function(){
	
	jQuery('input.btSalvaAnota:button').live('click',function(e){
		var dia=jQuery('input[name=dia]:hidden').val();
		var texto=jQuery('textarea[name=anotacao]').val();
		var td=jQuery('td#day'+dia);
		td[0].getChildren('div.txt')[0].store('full',texto)
		salvaDia(td[0],false,texto);
	});
	
	// Calendario
	new Calendar({
		calContainer:'showCalendar',
		newDate:todayis,
		ajaxDadosPath:ajaxDadosUrl,
		imagesPath:baseImages
	});
	
	// Tips
	var agendaTips=new Tips($$('img.tips'),{
		className:'agendaTip',
		offset: {x:-10,y:-35},
		fixed:true
	});
	//
    jQuery('img[draggable=true]').bind('dragstart',dragStartEvent).bind('dragend',dragEndEvent);
});

// Drag and Drop Events
var over=false;
//
function dragStartEvent(e){
	jQuery(this).addClass('dragando');
	return true;
}

function dragEndEvent(e){
	var img=jQuery(this);
	img.removeClass('dragando');
	if(!over&&img.hasClass('clonado'))img.remove();
	jQuery('td.droppable').removeClass('cinza');
	over=false;
	salvaAll();
	e.stopPropagation();
	return false;
}

function dragEnterEvent(e){
	jQuery(e.target).addClass('cinza');
	over=true;
	e.preventDefault();
	return false;
}

function dragLeaveEvent(e) {
	jQuery(e.target).removeClass('cinza');
	over=false;
	e.preventDefault();
	return false;
}

function dragOverEvent(e){
	e.preventDefault();
	return false;
}

function dropEvent(e){
	over=true;
	var img=jQuery('img.dragando');
	var alt=img.attr('alt');
	var d=jQuery(this);
	var t=d.find('img.'+alt).length;
	if(!t){
		if(img.hasClass('clonado'))d.append(img);
		else img.clone(true).addClass('clonado').removeClass('dragando').appendTo(d);
	}
	e.stopPropagation();
	return false;
}

function salvaDia(td,all,texto){
	var icons=[];
	jQuery(td).find('img.clonado').each(function(idx,item){
		icons[idx]=jQuery(item).attr('alt');
	})
	var dados={"icons":icons,"schedule":td.retrieve('ymd'),"tdId":td.get('id')};
	if(!all){
		if(texto)$extend(dados,{"annotation":texto});
		else $extend(dados,{"annotation":false});
	}else{
		$extend(dados,{"all":true});
	}
	postaAjax(dados);
}

function salvaAll(){
	jQuery('td.droppable').each(function(idx,item){
		salvaDia(item,true);
	});
}

function postaAjax(dados){
	var ajax=new Request.JSON({
		url: ajaxDadosPosta,
		data: dados,
		noCache: true,
		onRequest:function(){
			$('loadingCalendar').addClass('loadingShow');
		},
		onSuccess:function(response){
			$('loadingCalendar').removeClass('loadingShow');
			if(dados.annotation){
				if(response.shorttext){
					jQuery('td#'+dados.tdId).find('div.txt').html(response.shorttext);
				}
			}else if(!dados.all){
				jQuery('td#'+dados.tdId).find('div.txt').html("");
			}
		}
	}).get();
}