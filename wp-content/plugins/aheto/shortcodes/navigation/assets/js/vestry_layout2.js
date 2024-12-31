; (function ($, window, document, undefined) {
    "use strict";

    let $megaMenuBlock = $('.main-header--vestry-lite .sub-menu.mega-menu');

    if ($megaMenuBlock.length) {

        $megaMenuBlock.each(function () {

            let $megaMenuItem = $(this).closest('.menu-item--mega-menu');

            let $megaMenuItemPosition = $megaMenuItem.offset().left - $('.menu-home-page-container').offset().left + 15;

            $(this).append('<span class="mega-menu-arrow"></span>');

            $(this).find('.mega-menu-arrow').css({
                'left': ($megaMenuItemPosition + 30)
            })
        })
    }

    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('.aheto-header--fixed').addClass('vestry-header-scroll-2');
        } else {
            $('.aheto-header--fixed').removeClass('vestry-header-scroll-2');
        }
    });

})(jQuery, window, document);