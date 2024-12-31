;(function ($, window, document, undefined) {
    'use strict';

    function position() {
        if ($('.aheto-contents__prego-cards .swiper').length) {
            $('.aheto-contents__prego-cards .swiper').each(function () {
                let leftPosition = $(this).offset().left;
                let rightPosition = $(window).width() - leftPosition;

                $(this).find('.swiper-container').css('width', rightPosition);
            })
        }
    }

    $(window).on('load resize orientationchange', function () {
        position();
    })

})(jQuery, window, document);