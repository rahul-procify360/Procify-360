;(function ($, window, document) {

    let mobileMenu = 1199;

    function ahetoMobileMenu() {

        if ($('header .main-header[data-mobile-menu]').length) {

            mobileMenu = $('header .main-header[data-mobile-menu]').data('mobile-menu');
        }
    }

    ahetoMobileMenu();

	function fixForFixedMenu1() {
		if($('header').hasClass('aheto-header--fixed')){
			let height = $('.main-header--grid-mooseoom').height();
			if($(window).width() > mobileMenu){
				$('body').css('padding-bottom', '0');
				$('body').css('padding-top', height + 50);
			}else if (($(window).width() < 1026) && (($(window).width() > 1020)) ) {
				$('body').css('padding-bottom', '0');
				$('body').css('padding-top', '125px');
			}
			else if($(window).width() > 376){
				$('body').css('padding-bottom', '0');
				$('body').css('padding-top', height + 89);
			}
		}
	}

	function activeDropDown () {
		if($(window).width() <= mobileMenu) {
			if ($('.main-header.main-header--grid-mooseoom .dropdown-btn').length) {
				$('.main-header.main-header--grid-mooseoom .dropdown-btn').on('click', function () {
					if($(this).parents('.sub-menu').length) {
						$(this).toggleClass('active-btn');
					} else {
						if ($(this).hasClass('active-btn')) {
							$(this).removeClass('active-btn');
						} else {
							$('.main-header.main-header--grid-mooseoom .dropdown-btn.active-btn').toggleClass('active-btn');
							$(this).toggleClass('active-btn');
						}
					}
				});
			}
		} else {
			if ($('.main-header.main-header--grid-mooseoom .dropdown-btn').length) {
				$('.main-header.main-header--grid-mooseoom .dropdown-btn').on('click', function () {
					if ($(this).hasClass('active-btn')) {
						$(this).removeClass('active-btn');
					} else {
						$(this).toggleClass('active-btn');
					}
				});
			}
		}
	}


	$(window).on('load resize orientationchange', function () {
        setTimeout(ahetoMobileMenu, 100);
		fixForFixedMenu1();
		activeDropDown();
	});

})(jQuery, window, document);
