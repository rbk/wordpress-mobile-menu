jQuery(document).ready(function($){

	$('#rbk-mobile-menu li.menu-item-has-children > a').append('<i class="ion-ios-plus-empty">+</i>')

	$(document).on('touchstart click', '#rbk-open-menu', function(e){
		e.preventDefault();
		e.stopPropagation();
		if( !$('#rbk-mobile-menu').hasClass('down') ){
			$('body').addClass('overflow-hidden');
			$('#rbk-mobile-menu').slideDown().addClass('down');
		} else {
			$('body').removeClass('overflow-hidden');
			$('#rbk-mobile-menu').slideUp().removeClass('down');				
		}
	});

	$(document).on('touchstart click', 'li.menu-item-has-children > a i.ion-ios-plus-empty, li.menu-item-has-children > a i.ion-ios-close-empty', function(e){
		e.preventDefault();
		e.stopPropagation();
		if( $(this).hasClass('ion-ios-plus-empty') ){
			$(this).removeClass('ion-ios-plus-empty');
			$(this).addClass('ion-ios-close-empty');
		} else {
			$(this).addClass('ion-ios-plus-empty');
			$(this).removeClass('ion-ios-close-empty');
		}
		$(this).parent().parent().find('.sub-menu').slideToggle();
	});


});