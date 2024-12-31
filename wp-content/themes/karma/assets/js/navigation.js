/**
 * Header menu
 */
;(function ($, window, document, undefined) {
    'use strict';


    const mobileMenuBreakpoint = 1199;
    let winW = null;


    /* ============================ */
    /* CALCULATE WINDOW SIZE (width, height) */

    /* ============================ */
    function calcWinSizes() {
        winW = window.innerWidth;
    }


    $(window).on('load resize orientationchange', function () {
        calcWinSizes();
    });


    /*=================================*/
    /* MOBILE MENU */
    /*=================================*/


    if ($('.karma-header--wrap').length) {

        // Add dropdown arrow to items with childrens
        $('.karma-header--wrap .menu-item-has-children > a').after('<span class="dropdown-btn"></span>');

        // click menu item
        $('.karma-header--wrap').find('.menu-item-has-children .dropdown-btn').on('click', function (e) {
            e.stopPropagation();
            if (winW <= mobileMenuBreakpoint) {
                var parentItems = $(this).parent().parent().parent().parent();

                if (parentItems.hasClass('karma-header--menu-wrapper')) {
                    $(this).closest('.karma-header--menu-wrapper').find('.dropdown-btn').not(this).next('.sub-menu').slideUp();
                }

                $(this).next('.sub-menu').slideToggle();
            }
        });

    }


    $('.karma-header--mob-nav__hamburger').on('click', function (e) {
        e.preventDefault();

        var adminBarH = 0;

        $(this).toggleClass('active');

        if ($(this).hasClass('active')) {
            $('html').addClass('no-scroll');
            $('body').addClass('sidebar-open');
            $('.karma-header--menu-wrapper').addClass('menu-open');
        } else {
            $('html').removeClass('no-scroll');
            $('body').removeClass('sidebar-open');
            $('.karma-header--menu-wrapper').removeClass('menu-open');
        }

    });

    function resizeMenu() {
        if ($(window).width() > 1199 && $('html').hasClass('no-scroll')) {
            $('html').removeClass('no-scroll').height('auto');
        } else {

            var adminBar = 0;

            if ($('#wpadminbar').length) {
                adminBar = $(window).width() && $('#wpadminbar').length > 782 ? 32 : 46;
            }

            var menuHeight = $(window).height() - adminBar;

            $('.karma-header--menu-wrapper').outerHeight(menuHeight);
        }
    }


    $(window).on('load resize orientationchange', function () {
        resizeMenu();
    })

})(jQuery, window, document);
