; (function ($, window, document, undefined) {
    "use strict";
    $(window).on('load resize orientationchange', () => {
        if ($(window).width() > 1439) {

            let $blockOutCont = ($(window).outerWidth(true) - $('.elementor-section.elementor-section-boxed>.elementor-container').width() - 15) / 3;
            $('.aheto-tm-wrapper--mooseoom-dropleft .swiper').css({
                'left': $blockOutCont
            });
        } else if ($(window).width() < 1439) {
            let $blockOutCont = ($(window).outerWidth(true) - $('.elementor-section.elementor-section-boxed>.elementor-container').width() - 15) / 4.5;
            $('.aheto-tm-wrapper--mooseoom-dropleft .swiper').css({
                'left': $blockOutCont
            });

        } else if (($(window).width() < 1400) && (($(window).width() > 1281))) {
            $('.aheto-tm-wrapper--mooseoom-dropleft .swiper').css({
                'left': 0
            });
        }

    })

})(jQuery, window, document);
