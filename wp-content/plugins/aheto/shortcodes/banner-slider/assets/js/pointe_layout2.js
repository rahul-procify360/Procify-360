;(function ($, window, document, undefined) {
    'use strict';

    function cs_banner_slider_height(){

        if($('.cs-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            let headerH = header.length ? header.outerHeight() : 0;

            $('.cs-full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH );
        }
    }

    $(window).on('load resize orientationchange', function () {

        cs_banner_slider_height();

    });

    if ( window.elementorFrontend ) {
        cs_banner_slider_height();
    }

})(jQuery, window, document);