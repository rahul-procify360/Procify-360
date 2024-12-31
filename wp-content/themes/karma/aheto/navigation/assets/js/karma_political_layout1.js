;(function ($, window, document) {
    "use strict";


    // //Custom Scrollbar in header menu
    // function karma_political_menu_height() {
    //     const asideMenu         = $(".main-header--classic--kunst");
    //     const mainLineAsideMenu = $(".main-header__main-line");
    //     const menuWrapper       = $(".menu-home-page-container");
    //     const menu              = $(".main-menu");
    //     let menuHeight;
    //     let widgetsHeight       = 0;
    //     let logoHeight          = 0;
    //     let ww                  = 0;
    //
    //     if ($('.main-header--classic--karma-political').length !== 0) {
    //         $('body').addClass('karma-politicalaside-menu');
    //     }
    //
    //     if ($(window).width() > 1200) {
    //         ww = $('body.karma-politicalaside-menu').width() + 1;
    //
    //         $('body.karma-politicalaside-menu > .container .vc_row[data-vc-full-width], body.karma-politicalaside-menu > .container .elementor-section.elementor-section-stretched').css('max-width', ww);
    //         $('body.karma-politicalaside-menu > .aheto-footer > .container .vc_row[data-vc-full-width], body.karma-politicalaside-menu > .aheto-footer > .container .elementor-section.elementor-section-stretched').css('max-width', ww);
    //
    //         menuHeight = $(window).height() - mainLineAsideMenu.css('padding-top').replace('px', '') - mainLineAsideMenu.css('padding-bottom').replace('px', '');
    //
    //         if (asideMenu.find('.main-header__logo').length) {
    //             logoHeight = asideMenu.find('.main-header__logo').outerHeight();
    //             menuHeight = menuHeight - logoHeight;
    //         }
    //         if (asideMenu.find('.main-header__widget-box').length) {
    //             widgetsHeight = asideMenu.find('.main-header__widget-box').outerHeight();
    //             menuHeight    = menuHeight - widgetsHeight;
    //         }
    //
    //         menuWrapper.outerHeight(menuHeight);
    //         menu.css('max-height', menuHeight);
    //
    //     } else {
    //         $('body.karma-politicalaside-menu > .container .vc_row[data-vc-full-width], body.karma-politicalaside-menu > .container .elementor-section.elementor-section-stretched').css('max-width', 'auto');
    //         $('body.karma-politicalaside-menu > .aheto-footer > .container .vc_row[data-vc-full-width], body.karma-politicalaside-menu > .aheto-footer > .container .elementor-section.elementor-section-stretched ').css('max-width', 'auto');
    //         menuWrapper.outerHeight('auto');
    //         menu.css('max-height', 'auto');
    //     }
    // }

    //Menu box height
    // function menuHeight() {
    //     const $WIN                 = $(window);
    //     const $body                = $('body');
    //     const wpAdminBar           = $('#wpadminbar');
    //     const BREAKPOINTS          = {
    //         xs: 575,
    //         sm: 768,
    //         md: 992,
    //         lg: 1200
    //     };
    //
    //     const mobileMenuBreakpoint = 1200;
    //     let winW                   = null;
    //     let winH                   = null;
    //     let wpAdminBarH            = 0;
    //     winW = window.innerWidth;
    //     winH = window.innerHeight;
    //
    //     if ($('.aheto-header').length && (winW <= mobileMenuBreakpoint)) {
    //         const $header = $('.aheto-header');
    //
    //         if ($body.hasClass('admin-bar') && winW > 782) {
    //             wpAdminBarH = 32;
    //         } else if ($body.hasClass('admin-bar')) {
    //             wpAdminBarH = 46;
    //         }
    //
    //         $('.main-header').each(function () {
    //             let menuBoxH = winH - $(this).outerHeight() - wpAdminBarH;
    //
    //             $(this).find('.main-header__menu-box').css('height', menuBoxH);
    //         });
    //     } else {
    //         $('.main-header').each(function () {
    //             $(this).find('.main-header__menu-box').css('height', 'auto');
    //         });
    //     }
    //
    //     if (winW > 1200) {
    //         $body.removeClass('overflow-hidden');
    //     } else if ($('.aheto-header .js-toggle-mobile-menu').length && $('.aheto-header .js-toggle-mobile-menu').hasClass('is-active')) {
    //         $('html,body').animate({
    //             scrollTop: $('.aheto-header .main-header-js').offset().top - wpAdminBarH
    //         }, 'slow');
    //     }
    // };

    // let bodyWidthInElementor = () => {
    //     let header = document.querySelector('.main-header--classic--karma-political');
    //     let elementorBody = document.querySelector('body.page-template');
    //     let elementorContainer = document.querySelector('body.page-template .container .elementor-section.elementor-section-stretched');
    //     let footer = document.querySelector('body.aheto-footer-template');
    //
    //     if (!header) {
    //         elementorBody.style.paddingLeft = '0';
    //         elementorContainer.style.maxWidth = "100%";
    //         elementorContainer.style.left = "0";
    //         footer.style.paddingLeft = '0';
    //     }
    //
    // };

    $(window).on('load resize', function () {
        $('body').find('.body-overlay').hide();

        var x = false;

        $('.main-header--karma-political__menu .hamburger').on('click', function() {
            if (!x) {
                $('.main-header--karma-political__menu .hamburger-inner').addClass('active');
                $('.main-header--karma-political__menu .main-header__menu-box').addClass('is-active-menu');

                x = true;
            } else {
                $('.main-header--karma-political__menu .hamburger-inner').removeClass('active');
                $('.main-header--karma-political__menu .main-header__menu-box').removeClass('is-active-menu');
                $('body').removeClass('no-scroll');

                x = false;
            }
        });
    });

})(jQuery, window, document);