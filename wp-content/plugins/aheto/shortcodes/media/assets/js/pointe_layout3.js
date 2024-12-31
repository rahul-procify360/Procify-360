; (function ($, window, document, undefined) {
    "use strict";

    function pointe_popup() {
        if ($('.aheto_media--pointe-gall .aheto_media__img').length) {
            $('.aheto_media--pointe-gall .aheto_media__img').each(function () {
                $(this).magnificPopup({
                    delegate: 'div',
                    type: 'image',
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 1]
                    }
                });
            });
        }
    }



    $(window).on('load', function () {
        pointe_popup();

    });

})(jQuery, window, document);