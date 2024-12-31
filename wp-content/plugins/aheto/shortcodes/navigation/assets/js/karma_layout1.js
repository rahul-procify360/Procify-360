;(function ($, window, document, undefined) {

    function karma_demo_menu() {
        if ($('.main-header--karma-political__menu').length) {

            var maxW = $('.main-header--karma-political__menu .main-header__menu-box').outerWidth();

            var menuH = $('.main-header--karma-political__menu').innerHeight();
            var menuInnerH = $('.main-header--karma-political__menu .menu-home-page-container').innerHeight();
            $('.main-header--karma-political__menu .menu-item--mega-menu .mega-menu').css('top', (menuH - menuInnerH) / 2 + menuInnerH);

            if ($('.main-header--karma-political__menu .main-header__pages-list').length) {

                $('.main-header--karma-political__menu .main-header__pages-list').css({
                    'width': maxW,
                    'max-height': $(window).innerHeight() - menuH - 50
                });
            }
        }
    }

    $(window).on('load', function () {
        karma_demo_menu();
        if ($('.main-header--karma-political__menu').length) {
            $('body').addClass('aheto-menu--karma-simple');
        }

    });

    $(window).on('resize orientationchange', function () {
        karma_demo_menu();
    });

})(jQuery, window, document);
