window.addEvent('domready',function(){
	new tipGuia('a.tips',{
		mask:baseCss+'assets/maskMascote.png',
		//pathImage:baseImages+'temp/'
		pathImage:'http://www.efeitofrontline.com.br/racas-cachorro/images/racas-cachorros-filhotes-resultados/'
	});
	
	var menu = new BouncyMenu('doglista');
		
});

var BouncyMenu = new Class({

  initialize: function(element){
        this.elements = document.id(element).getChildren();
        this.attach();
    },
    
    attach: function(){
        this.elements.each(function(element, index){
	
			jQuery(element).find('div').each(function(idx,el){
				
				dbug.log(idx,el.getScrollHeight(),element.getWidth());
				element.set('tween',{ link: 'cancel' });

				element.addEvents({
					mouseenter: function(){
						el.set('tween',{ transition: 'circ:out' })
						.tween('height', el.getScrollHeight())
						.setStyle('z-index',200);
					},
					mouseleave: function(){
						el.set('tween',{ transition: 'circ:out' })
						.tween('height', 90)
						.setStyle('z-index',10);
					}
				});
			});
            
        }, this);
        
        return this;
    }

});


var tipGuia=new Class({
	Implements:[Options, Events],
	options:{
		mask:'maskMascote.png',
		pathImage:'',
		classe:'frame',
		ext:'jpg',
		top:47,
		left:5
	},
	initialize:function(el,options){
		this.setOptions(options);
		//
		this.div=new Element('div',{'class':'tipDiv','style':'display:none'}).inject(document.body);
		this.img=new Element('img',{'src':this.options.mask,'alt':'mask','class':this.options.classe}).inject(this.div);
		//
		this.el=el;
		this.attach(this.div,this.img);
	},
	attach:function(div,img){
		var base=this.options.pathImage;
		var ext=this.options.ext;
		var top=this.options.top;
		var left=this.options.left;
		//
		jQuery(this.el).each(function(idx,element){			
	        element.addEvents({ 
	            mouseenter: function(){
					var coords=element.getCoordinates();
					dbug.log(element.get('rel'));
					jQuery(img).css({"background-image":"url('"+base+element.get('rel')+"."+ext+"')"});
					jQuery(div).css({"top":coords.top-top,"left":coords.left+coords.width+left,"display":""});
					div.fade('in');
	            }, 
	            mouseleave: function(){
					div.fade('out');
	            }
	        });
		});
	}
});