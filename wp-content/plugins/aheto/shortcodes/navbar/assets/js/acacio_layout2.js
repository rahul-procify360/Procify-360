
;(function ($, window, document, undefined) {
    "use strict";

    let positionElement = 0;

    if ($('.aheto-navbar--acacio-additional.fixed-additional .aheto-navbar--inner').length) {
        positionElement = $('.aheto-navbar--acacio-additional.fixed-additional .aheto-navbar--inner').offset().top - 1;
    }

    function fixedAdditionalMenuOnScroll() {

        let positionTop = 0;

        if ($('body').hasClass('admin-bar')) {

            let wpAdminBarH = $(window).width() > 782 ? 32 : 46;

            positionTop += wpAdminBarH;
        }

        if ($('.aheto-header.aheto-header--fixed').length) {

            positionTop += $('.aheto-header.aheto-header--fixed').outerHeight();

        }

        const menu = $('.aheto-navbar--acacio-additional.fixed-additional .aheto-navbar--inner');

        if (menu.length) {

            let windowTop = $(window).scrollTop() + positionTop;

            if ( windowTop > positionElement) {

                menu.addClass('aheto-navbar--fixed').css({
                    'top': positionTop - 1,
                    'transition': 'all 0.7s'
                });

            } else if( windowTop <= positionElement ) {

                menu.removeClass('aheto-navbar--fixed');
            }

        }

    }

    $(window).on('load resize scroll orientationchange', function () {

        fixedAdditionalMenuOnScroll();

    });



})(jQuery, window, document);
