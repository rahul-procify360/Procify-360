/**
 * CF7 Input Wrap
 * ==============================================
 */

;(function ($, window, document, undefined) {
    "use strict";

        if ( $('.aheto-form--noize-lay1 input[type="submit"]').length ) {

            $('.aheto-form--noize-lay1 input[type="submit"]').each(function () {

                let textColor = $(this).css('background-color');

                $(this).closest('.aheto-form--noize-lay1').css('color', textColor);

            });

        }

})(jQuery, window, document);
