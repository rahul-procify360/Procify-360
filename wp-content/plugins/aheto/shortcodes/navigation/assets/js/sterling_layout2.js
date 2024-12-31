;(function ($, window, document, undefined) {
    "use strict";

    let $megaMenuBlock = $('.sub-menu.mega-menu');

    if ( $megaMenuBlock.length ) {

        $megaMenuBlock.each(function () {

            let $megaMenuItem = $(this).closest('.menu-item--mega-menu');

            if($megaMenuItem.length){
				let $megaMenuItemPosition = $megaMenuItem.offset().left - $('.menu-home-page-container').offset().left + 15;

				$(this).append('<span class="mega-menu-arrow"></span>');

				$(this).find('.mega-menu-arrow').css({
					'left' : ( $megaMenuItemPosition + 30 )
				})
			}
        })
    }

    $(window).scroll(function(){
		if($('.aheto-header--fixed').length){
			if ($(this).scrollTop() > 10) {
				$('.aheto-header--fixed').addClass('header-scroll-2');
			} else {
				$('.aheto-header--fixed').removeClass('header-scroll-2');
			}
		}
    });

    function sterling_demo_menu_width() {

        if ($('.main-header--sterling-lite').length) {

            var maxW = $('.main-header--sterling-lite .main-header__main-line').outerWidth();

            var menuH = $('.main-header--sterling-lite .main-header__main-line').innerHeight();
            var menuInnerH = $('.main-header--sterling-lite .menu-home-page-container').innerHeight();
            $('.main-header--sterling-lite .menu-item--mega-menu .mega-menu').css('top', (menuH - menuInnerH) / 2 + menuInnerH);

            if ($('.main-header--sterling-lite .main-header__pages-list').length) {

                $('.main-header--sterling-lite .main-header__pages-list').css({
                    'width': maxW,
                    'max-height': $(window).innerHeight() - menuH - 50
                });
            }
        }
    }

    $(window).on('load', function () {
        sterling_demo_menu_width();
        if ($('.main-header--sterling-lite').length) {
            $('body').addClass('aheto-menu--sterling-lite');
        }

    });

    $(window).on('resize orientationchange', function () {
        sterling_demo_menu_width();
    });

})(jQuery, window, document);
