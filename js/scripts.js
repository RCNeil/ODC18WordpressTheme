(function ($, root, undefined) { $(function () { 'use strict';

	contentAnimations();
	function contentAnimations() {
		if(Modernizr.csstransitions) {			
			$('.animate').on('inview', function(event, isInView) {
				if (isInView) {
					$(this).addClass('animation');
				}
			});
		}
	}

	mobileToggle();
	function mobileToggle() {
		$('.mobile-menu').click(function(e) {
			e.preventDefault();
			$(this).blur();
			if($('.header').hasClass('opened')) {
				$('.header').removeClass('opened');
			} else {
				$('.header').addClass('opened');
			}
		});	
	}
	
	loginCheck();
	function loginCheck() {
		if($('#user_login').length) {
			$('#user_login').attr({"placeholder" : "Email","required" : "required"});
			$('#user_pass').attr({"placeholder" : "Password","required" : "required"});
		}
	}
	
	toggleRidesViews();
	function toggleRidesViews() {
		$('.toggle-view').click(function(e) { 
			e.preventDefault;
			$(this).blur();
			if(!$(this).hasClass('active')) {
				var view = $(this).attr('data-view'); 
				$('*').removeClass('active');
				$('.' + view).addClass('active'); 
			}
		});
	}
	

}); })(jQuery, this);