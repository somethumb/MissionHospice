// JavaScript Document
jQuery(document).ready(function(){
	'use strict';	
	jQuery('ul.navp').superfish();
	if (jQuery('#gform_1').length) {
		jQuery('#input_1_31, #input_1_32, #input_1_33').blur (function() {
			var fieldval = jQuery(this).val();
			var newfieldval = Math.round(fieldval);
			if(!isNaN(newfieldval)) {
			   // it's a number
			   jQuery(this).val(newfieldval);
			} else {
			   // it's NOT a number
			   jQuery(this).val('');
			}
		});
	}	
});

/* Mobile Menu */
jQuery(document).ready(function(){
	'use strict';
	var main_menu = jQuery('#navm');

	main_menu.prepend('<a href="#" class="close-menu close-main-menu"><i class="fa fa-times" aria-hidden="true"></i>Close</a>');

	jQuery('#navm .sub-menu').css('min-height', jQuery('#navm').height() + 'px');

	jQuery('#navm a').each(function(){
		if (jQuery(this).next().is('.sub-menu')){
			jQuery(this).addClass('has-submenu');
			jQuery(this).append('<i class="fa fa-chevron-right" aria-hidden="true"></i>');
			jQuery(this).next().prepend('<a href="#" class="close-menu"><i class="fa fa-chevron-left" aria-hidden="true"></i>Back</a>');
		}
	});

	function show_menu(el){
		el.addClass('revealed');
	}

	function hide_menu(el){
		el.removeClass('revealed');
	}

	jQuery(document).on('click', '.modal-overlay', function(e){
		e.preventDefault();
		hide_menu(main_menu);
		jQuery('.modal-overlay').remove();
	});

	jQuery(document).on('click', "#navm .has-submenu", function(e){
		e.preventDefault();
		show_menu(jQuery(this).next());
		jQuery('.navmt').hide();
	});

	jQuery(document).on('click', '#navm .close-menu', function(e){
		e.preventDefault();
		hide_menu(jQuery(this).parent());

		if (jQuery(this).is('.close-main-menu')){
			jQuery('.modal-overlay').remove();
		} else {
			jQuery('.navmt').show();
		}
	});

	jQuery(document).on('click', '.menu-toggle', function(){
		show_menu(main_menu);
		jQuery('#navm').after('<div class="modal-overlay"></div>');
	});

});