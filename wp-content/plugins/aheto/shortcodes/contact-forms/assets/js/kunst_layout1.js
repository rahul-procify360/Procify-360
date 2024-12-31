/**
 * Kunst CF7 Input Wrap
 * ==============================================
 */

;(function ($, window, document, undefined) {
    "use strict";

    if ($('.widget_aheto__cf--kunst__subscribe-single input[type="submit"]').length) {
        $('.widget_aheto__cf--kunst__subscribe-single input[type="submit"]').each(function () {
            $(this).wrap('<div class="submit-wrap ion-ios-paperplane"></div>')
        })
    }

})(jQuery, window, document);