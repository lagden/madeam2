var Demo = {
	map:null,
	infoWindow: null,
	geocoder:null,
	markers:{},
	mgr:{},
	showMarketManager:true
};

window.addEvent('domready',function(){
	
	var pin=baseImages+'pinPatinha.png';
	
	jQuery("select.uf").change(function(){
		if(this.value){
			jQuery.ajax({
				type:'GET',
				url:baseUrl+'index/lojas',
				dataType:'json',
				data:{'uf':this.value},
				success:function(data){
					Demo.closeInfoWindow();
					Demo.clearMarkers();
					Demo.map.setZoom(3);
					jQuery('ul#listaLojas').html('');
					jQuery('div#chkboxes').html('');
					Demo.buildCheckbox(data.tipos);
					delete data.tipos;
					Demo.findAndAdd(data);
				}
			});
		}
	});
	
	jQuery('button.geoCodeButton').click(function(){Demo.codeAddress();});
	jQuery("input#address:text").mask("99999-999");
	
	Demo.closeInfoWindow = function() {
		Demo.infoWindow.close();
	};

	Demo.openInfoWindow=function(mker,info) {
		location='#mapCanvas';
		Demo.infoWindow.setContent('<div class="gmapInfo"><h1>'+info.loja+'</h1><p>'+info.geral+'</p></div>');	
		Demo.infoWindow.open(Demo.map, mker);
		Demo.map.setZoom(16);
	};
	
	Demo.buildCheckbox=function(tipos){
		var ul=jQuery('<ul></ul>').appendTo('div#chkboxes');
		jQuery.each(tipos,function(idx,obj){
			jQuery('<li><label>'+idx+'<input class="markerss" type="checkbox" value="'+obj+'" /></label></li>').appendTo(ul);
		});
		jQuery('input.markerss:checkbox').click(function(){
			Demo.toggleMarkers(this,this.value);
			Demo.toggleList(this,this.value);
		});
	};
	
	Demo.clearMarkers=function(){
		for(var level in Demo.markers){
			while(Demo.markers[level][0]){
				Demo.markers[level].pop().setMap(null);
			}
		}
	};
	
	Demo.toggleMarkers=function(checkbox,tipo){
		jQuery.each(Demo.markers[tipo],function(idx,obj){
			obj.setVisible(checkbox.checked);
			if(!checkbox.checked)Demo.closeInfoWindow();
		});
	};
	
	Demo.toggleList=function(checkbox,tipo){
		if(checkbox.checked)jQuery('li.'+tipo).show();
		else jQuery('li.'+tipo).hide();
	};
	
	Demo.init = function() {
		Demo.geocoder = new google.maps.Geocoder();
		var latlng = new google.maps.LatLng(-23.61771,-46.690736);
		var opt = {
			zoom: 3,
			scrollwheel: false,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
		Demo.map=new google.maps.Map(document.getElementById("mapCanvas"), opt);
		Demo.infoWindow=new google.maps.InfoWindow({content:'<div class="gmapInfo"></div>'});
		//
		// Zoom
		google.maps.event.addListener(Demo.map,'zoom_changed',function(){dbug.log(Demo.map.getZoom());});
		google.maps.event.addListener(Demo.map,'click',Demo.closeInfoWindow);
	};
	
	Demo.codeAddress=function(){
		var address = document.getElementById("address").value;
		Demo.geocoder.geocode({'address':address+', Brazil'},
		function(results, status){
			if(status==google.maps.GeocoderStatus.OK){
				Demo.map.setZoom(15);
				Demo.map.setCenter(results[0].geometry.location);
			}else{
				alert("Geocode was not successful for the following reason: " + status);
			}
		});
	}
	
	Demo.findAndAdd=function(markers){
		for(var level in markers){
			var i=0;
			Demo.markers[level]=[];
			jQuery.each(markers[level],function(idx,el){
				Demo.addMarker(el,level,markers,i);
				i++;
			});
			Demo.toggleList({checked:false},level);
		}
	};
	
	Demo.addMarker=function(obj,level,markers,pos){
		var ll=new google.maps.LatLng(obj.ll.lat,obj.ll.lon);
		Demo.markers[level][pos]=new google.maps.Marker({
			map:Demo.map,
			title:level,
			position:ll,
			icon:pin,
			visible:false
		});
		//
		google.maps.event.addListener(Demo.markers[level][pos],'click',function() {
			Demo.openInfoWindow(Demo.markers[level][pos],obj.dados);
		});
		//
		var li=jQuery('<li class="'+obj.dados.tipo+'"><h1>'+obj.dados.loja+'</h1><p>'+obj.dados.geral+'</p></li>').appendTo('ul#listaLojas');
		li.click(function(){
			Demo.openInfoWindow(Demo.markers[level][pos],obj.dados);
		});
	};
	
	google.maps.event.addDomListener(window,'load',Demo.init);

});