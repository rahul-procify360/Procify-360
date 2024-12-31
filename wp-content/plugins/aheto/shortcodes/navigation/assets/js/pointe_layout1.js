;(function ($, window, document, undefined) {
    "use strict";

    $(window).on('load', function () {
        const widgetName = $('#wpadminbar');
        if (widgetName.length) {
            $('.desk-menu__close-wrap').css('margin-top', '15px');
        }

    });


    $(document).on('ready', function () {


        const $hamburger = $('.aheto-header .js-toggle-desk-menu');
        let menuBox = $('.main-header').find('.main-header__desk-menu-wrapper');

        // Hamburger click
        $hamburger.on('click', function () {
            menuBox.addClass('menu-open');
        });

        // Close click
        $('.desk-menu__close').on('click', function () {
            menuBox.removeClass('menu-open');
        });

    });




})(jQuery, window, document);