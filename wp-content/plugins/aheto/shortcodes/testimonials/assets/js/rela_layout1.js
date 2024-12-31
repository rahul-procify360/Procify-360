;(function ($, window, document, undefined) {
    $(window).on('load', () => {
        if ($(window).width() > 1200) {
            let $blockOutCont = ($(window).outerWidth(true) - $('.elementor-section.elementor-section-boxed>.elementor-container').width() - 30) / 2;
            $('.aheto-tm-wrapper--rela-modern .swiper').css({
                'left': $blockOutCont
            });
        }
    })
})(jQuery, window, document);