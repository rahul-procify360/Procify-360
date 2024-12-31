;(function ($, window, document, undefined) {
    'use strict';

    let mobileMenu = 1199;
    let prevScrollpos = window.pageYOffset;

    function subMenuPositioning(block, item) {
        let $megaMenuBlock = $(block);
        let $megaMenuItem = $(item);

        if ( $megaMenuBlock.length && $(window).width() > 1024 ) {
            $megaMenuBlock.css({
                'left' : - ( ( $megaMenuBlock.outerWidth(true) / 2 ) - ( $megaMenuItem.width() / 2 ) )
            });
        }
    }

    function hideMenuOnScroll() {

        if ($('.main-header[data-mobile-menu]').length) {
            mobileMenu = $('.main-header[data-mobile-menu]').data('mobile-menu');
        }

        let currentScrollPos = window.pageYOffset;
        let headerHeight = $('.acacio-header-2-top').outerHeight();

        if($(window).width() > mobileMenu) {
            if (prevScrollpos > currentScrollPos) {

                $('.acacio-header-2-top').css({
                    'margin-top': `0px`,
                    'transition': '0.5s'
                });

            } else {
                $('.acacio-header-2-top').css({
                    'margin-top': `-${headerHeight}px`,
                    'transition': '0.5s'
                });


            }

            if(currentScrollPos == 0 || currentScrollPos < 100) {
                $('.acacio-header-2-top').css({
                    'margin-top': `0px`,
                    'transition': '0.5s'
                });
                if($('.main-header--simple-button .main-header__hamburger').hasClass('is-active')) {
                    $('.acacio-header-2-top').css({
                        'margin-top': `-${headerHeight}px`,
                        'transition': '0.5s'
                    });
                }
            }

            prevScrollpos = currentScrollPos;
        }
    }

    $(window).on('load scroll', function () {
        hideMenuOnScroll();
    });

})(jQuery, window, document);
