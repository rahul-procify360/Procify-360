/**
 * CF7 Input Wrap
 * ==============================================
 */

;(function ($, window, document, undefined) {
    "use strict";

    if($('.aheto-content-block--outsourceo-bgImg').length){
        $('.aheto-content-block--outsourceo-bgImg').hover(
            function () {
                $(this).find('.aheto-content-block__info').slideDown(200);
            },
            function () {
                $(this).find('.aheto-content-block__info').slideUp(200);
            }
        );
    }

})(jQuery, window, document);