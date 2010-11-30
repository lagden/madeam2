window.addEvent('domready',function(){
	jQuery('input.addpet:button').click(function(e){
		jQuery.get(ajaxUrl+'pet/',function(data){
			jQuery('div.injetaPet').append(data);
			jQuery('div.injetaPet').find('div.pet:first-child').find('hr').remove();
			jQuery("input.birthday").unmask();
			jQuery("input.birthday").mask("99/99/9999");
			formCheck.reinitialize('forced');
		});
	});
	
	jQuery('input.removepet:button').live('click',function(e){
		dbug.log(jQuery(this).parent().parent().parent().parent().parent().parent().parent().remove());
		jQuery('div.injetaPet').find('div.pet:first-child').find('hr').remove();
	});
	//
	jQuery('input.addpet:button').trigger('click');
	
	jQuery("input.birthday").mask("99/99/9999");
	
});