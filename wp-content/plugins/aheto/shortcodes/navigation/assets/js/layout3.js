;(function ($, window, document, undefined) {

    function aheto_demo_menu() {
        if ($('.main-header--modern').length) {

            var maxW = $('.main-header--modern .main-header__menu-box').outerWidth();
            var menuH = $('.main-header--modern .main-header__main-line').innerHeight();
            var menuInnerH = $('.main-header--modern .menu-home-page-container').innerHeight();
            $('.main-header--modern .menu-item--mega-menu .mega-menu').css('top', (menuH - menuInnerH) / 2 + menuInnerH);

            if ($('.main-header--modern .main-header__pages-list').length) {

                $('.main-header--modern .main-header__pages-list').css({
                    'width': maxW,
                    'max-height': $(window).innerHeight() - menuH - 50
                });
            }
        }
    }



	$(window).on('load resize orientationchange', function () {
		let $megaMenuBlock = $('.main-header--modern .main-header__menu-box.creative-submenu .sub-menu.mega-menu');

		if ($megaMenuBlock.length) {

			$megaMenuBlock.each(function () {

				let $megaMenuItem = $(this).closest('.menu-item--mega-menu');

				let $megaMenuItemPosition = $megaMenuItem.offset().left - ($(window).width() - $(this).width()) / 2;

				if (!$(this).find('.mega-menu-arrow').length) {
					$(this).append('<span class="mega-menu-arrow"></span>');
				}

				$(this).find('.mega-menu-arrow').css({
					'left': ($megaMenuItemPosition + 30)
				})
			})
		}
	});


    $(window).on('load', function () {
        aheto_demo_menu();
    });

    $(window).on('resize orientationchange', function () {
        aheto_demo_menu();
    });


})(jQuery, window, document);
