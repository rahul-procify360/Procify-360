;(function ($, window, document, undefined) {
    "use strict";

    $( () => {

        if($('.widget_aheto__cf--subscribe-simple input[type="submit"]').length){
            $('.widget_aheto__cf--subscribe-simple input[type="submit"]').each(function () {
                $(this).wrap('<div class="submit-wrap ion-ios-paperplane"></div>')
            })
        }

    });


})(jQuery, window, document);