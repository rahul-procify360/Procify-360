;(function ($, window, document, undefined) {
    'use strict';

    function ninedok_banner_slider_height() {

        if ($('.aheto-banner-slider--ninedok-modern .aheto-banner-slider-wrap').length) {

            const headerAbsolute = $('.aheto-header.aheto-header--absolute');
            const headerFixed = $('.aheto-header.aheto-header--fixed');


            if (headerAbsolute.length) {
                setTimeout(() => {
                    $('.aheto-banner-slider--ninedok-modern .swiper > div').addClass('active');
                }, 100);
            }
            if (headerFixed.length) {
                setTimeout(() => {
                    $('.aheto-banner-slider--ninedok-modern .swiper > div').addClass('active');
                }, 100);
            }

        }
    }

    $(window).on('load resize orientationchange', function () {

        ninedok_banner_slider_height();

    });


})(jQuery, window, document);
