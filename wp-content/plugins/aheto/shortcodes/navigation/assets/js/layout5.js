;(function ($, window, document, undefined) {

    function aheto_demo_menu() {
        if ($('.main-header--classic').length) {

            var maxW = $('.main-header--classic .main-header__main-line').outerWidth();
            var menuH = $('.main-header--classic .main-header__main-line').innerHeight();
            var menuInnerH = $('.main-header--classic .menu-home-page-container').innerHeight();
            $('.main-header--classic .menu-item--mega-menu .mega-menu').css('top', (menuH - menuInnerH) / 2 + menuInnerH);

            if ($('.main-header--classic .main-header__pages-list').length) {

                $('.main-header--classic .main-header__pages-list').css({
                    'width': maxW,
                    'max-height': $(window).innerHeight() - menuH - 50
                });
            }
        }
    }


    $(window).on('load', function () {

        aheto_demo_menu();
        if ($('.main-header--classic').length) {
            $('body').addClass('aheto-menu--aheto-simple');
        }

    });

    $(window).on('resize orientationchange', function () {
        aheto_demo_menu();
    });


})(jQuery, window, document);
