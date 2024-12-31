;(function ($, window, document, undefined) {
    "use strict";

    $(window).on('load', function () {
        if ($('#wpadminbar').length) {
            $('.desk-menu__close-wrap').css('margin-top', '30px');
        }
        if ($('.aheto-navbar--aira-modern').length) {
            $('.main-header--aira-second .main-header__main-line').css({'padding-top': '0','padding-bottom': '0'});
        }
    });


    $(document).on('ready', function () {


        const $hamburger = $('.aheto-header .js-toggle-desk-menu');
        let menuBox = $('.main-header').find('.main-header__desk-menu-wrapper');

        // Hamburger click
        $hamburger.on('click', function () {
            menuBox.addClass('menu-open');
            $('body').addClass('sidebar-open no-scroll');
            $('body').css('margin-left', '-15px');
            $('.aheto-header').css('margin-left', '-9px');
        });

        // Close click
        $('.desk-menu__close').on('click', function () {
            menuBox.removeClass('menu-open');
            $('body').removeClass('sidebar-open no-scroll');
            $('body').css('margin-left', 'unset');
            $('.aheto-header').css('margin-left', 'unset');
        });

    });




})(jQuery, window, document);