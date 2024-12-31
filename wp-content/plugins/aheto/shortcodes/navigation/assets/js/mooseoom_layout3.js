;(function ($, window, document) {

    let mobileMenu = 1199;

    function ahetoMobileMenu() {

        if ($('.main-header[data-mobile-menu]').length) {

            mobileMenu = $('header .main-header[data-mobile-menu]').data('mobile-menu');

        }
    }

    ahetoMobileMenu();

	function fixForFixedMenu() {
		if($('header').hasClass('aheto-header--fixed')){
			let height = $('.main-header--footer-mooseoom').height();
			if($(window).width() > mobileMenu){
				$('body').css('padding-bottom', height);
				$('body').css('padding-top', '0');
			}else{
				$('body').css('padding-top', height);
				$('body').css('padding-bottom', '0');
			}
		}
	}
	$(window).on('load resize orientationchange', function () {
        setTimeout(ahetoMobileMenu, 100);
		fixForFixedMenu();
	});

})(jQuery, window, document);
