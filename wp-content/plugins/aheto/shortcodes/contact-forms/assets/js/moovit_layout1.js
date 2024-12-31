/**
 * CF7 Input Wrap
 * ==============================================
 */

;(function ($, window, document, undefined) {
    "use strict";

    function cf_wrap(){
        if($('.widget_aheto__cf--moovit__subscribe-simple input[type="submit"]').length){

            $('.widget_aheto__cf--moovit__subscribe-simple input[type="submit"]').each(function () {

                let textColor = $(this).css('background-color');

                $(this).closest('.widget_aheto__cf--moovit__subscribe-simple').css('color', textColor);

            });

        }
    }


    $( () => {
        cf_wrap();
    });

    if ( window.elementorFrontend ) {
        cf_wrap();
    }


})(jQuery, window, document);

