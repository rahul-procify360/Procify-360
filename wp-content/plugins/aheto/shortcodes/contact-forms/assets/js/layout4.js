;(function ($, window, document, undefined) {
    "use strict";

    function cf_wrap() {
        if ($('.widget_aheto__cf--classic-form input[type="submit"]').length) {
            $('.widget_aheto__cf--classic-form input[type="submit"]').each(function () {
                $(this).wrap('<div class="submit-wrap"></div>')
            })
        }
        if ($('.widget_aheto__cf--classic-form textarea').length) {
            $('.widget_aheto__cf--classic-form textarea').each(function () {
                $(this).closest('.wpcf7-form-control-wrap').wrap('<div class="textarea-wrap"></div>')
            })
        }
    }

    cf_wrap();

    if ( window.elementorFrontend ) {
        cf_wrap();
    }

})(jQuery, window, document);