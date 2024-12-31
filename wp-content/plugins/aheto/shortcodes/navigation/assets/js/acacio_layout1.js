;(function ($, window, document, undefined) {
    'use strict';

    let mobileMenu = 1199;

    function megaMenu() {

        if ($('header .main-header[data-mobile-menu]').length) {
            mobileMenu = $('header .main-header[data-mobile-menu]').data('mobile-menu');
        }

        let $megaMenuBlock = $('.acacio-header-menu .sub-menu.mega-menu');

        let adminBar = $('#wpadminbar');

        if ( $megaMenuBlock.length && $(window).width() > mobileMenu) {
            if(adminBar.length) {
                $megaMenuBlock.css({
                    width: $('.acacio-header-menu .elementor-row').width() - 170 + 'px',
                    top: $('.acacio-header-menu').height() + 17 + 'px',
                });
            } else {
                $megaMenuBlock.css({
                    width: $('.acacio-header-menu .elementor-row').width() - 170 + 'px',
                    top: $('.acacio-header-menu').height() - 10 + 'px',
                });
            }

        }


    }

    function changeMenuOnScroll () {
        if($(this).scrollTop() > 30) {
            $('.acacio-header-menu .acacio-header-logo').hide();
            $('.acacio-header-menu').find('.elementor-row').first().css({
                'justify-content': 'center'
            })
        } else {
            $('.acacio-header-menu .acacio-header-logo').show();
            $('.acacio-header-menu').find('.elementor-row').first().css({
                'justify-content': 'initial'
            })
        }
    }


    $(window).on('load resize orientationchange', function () {

        $('.main-header--centered').closest('.elementor-section').addClass('acacio-header-menu');

        megaMenu();
    });

    $(window).on('load scroll', function () {
        changeMenuOnScroll();
    });


})(jQuery, window, document);
