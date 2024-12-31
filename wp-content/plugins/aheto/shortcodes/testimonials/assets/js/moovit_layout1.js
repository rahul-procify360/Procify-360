;(function ($, window, document, undefined) {
    "use strict";


    function testimonials() {

        if ($(window).width() > 1200) {

            let $blockOutCont = ($(window).outerWidth(true) - $('.elementor-section.elementor-section-boxed>.elementor-container').width() - 15) / 2;
            $('.aheto-tm-wrapper--moovit-modern .swiper').css({
                'left': $blockOutCont
            });
        } else {
            $('.aheto-tm-wrapper--moovit-modern .swiper').css({
                'left': 0
            });
        }
    }

    $(window).on('load resize orientationchange', () => {
        testimonials();

    });


    if (window.elementorFrontend) {
        testimonials();
    }


})(jQuery, window, document);