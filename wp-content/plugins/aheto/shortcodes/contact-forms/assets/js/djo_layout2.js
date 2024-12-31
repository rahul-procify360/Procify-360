/**
 * CF7 Input Wrap
 * ==============================================
 */

;(function ($, window, document, undefined) {
    "use strict";

    function formWrapp() {
        if($('.widget_aheto__cf--djo-classic-form input[type="submit"]').length){
            $('.widget_aheto__cf--djo-classic-form input[type="submit"]').each(function () {
                $(this).wrap('<div class="submit-wrap"></div>')
            })

        }
        if($('.widget_aheto__cf--djo-classic-form textarea').length){
            $('.widget_aheto__cf--djo-classic-form textarea').each(function () {
                $(this).closest('.wpcf7-form-control-wrap').wrap('<div class="textarea-wrap"></div>')
            })
        }
    }


    $( () => {
        formWrapp();
    });

    if (window.elementorFrontend) {
        formWrapp();
    }

})(jQuery, window, document);