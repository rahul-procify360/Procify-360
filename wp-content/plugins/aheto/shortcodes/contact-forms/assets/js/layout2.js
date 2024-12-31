;(function ($, window, document, undefined) {
    "use strict";

    $( () => {

        if($('.widget_aheto__cf--subscribe-modern input[type="submit"]').length){
            $('.widget_aheto__cf--subscribe-modern input[type="submit"]').each(function () {
                $(this).wrap('<div class="submit-wrap ion-arrow-right-c"></div>')
            })
        }

    });

})(jQuery, window, document);