window.addEvent('domready',function(){
		
	var addLista =  new ListaAction('div.add',{"path":path+'/new/'});
	var editaLista =  new ListaAction('img.editar',{"attr":'reg',"path":path+'/edit/'});
	var deletaLista =  new ListaAction('img.deletar',{"attr":'reg',"path":path+'/delete/',"confirma":true,"msg":'Deseja remover o registro?'});
	//
	setRow('table.listagem','reg',reg);
		
});

var ListaAction = new Class({
	
	Implements: Options,
	
	options: {
		attr:null,
		path:'/',
		msg:'Deseja efetuar?',
		confirma:false
	},

    initialize: function(element, options){
		this.setOptions(options);
        this.elements = $$(element);
        this.attach();
    },

    attach: function(){
        this.elements.each(function(element){
            var events={
				click:function(){
					var prop=(this.options.attr) ? element.getProperty(this.options.attr) : '';
					if(this.options.confirma){
						if(confirm(this.options.msg))location=this.options.path+prop;
					}else location=this.options.path+prop;
                }.bind(this)
            };
            element.addEvents(events);
        },this);
        return this;
    }

});

function setRow(table,att,v,css){
	var set=(css)?css:'set';
	jQuery(table).find('tbody').find('tr').removeClass(set);
	jQuery(table).find('tbody').find('tr['+att+'='+v+']').addClass(set);
}