;(function ($, window, document, undefined) {
    "use strict";

    $(window).on('load', function () {
        if ($('.aheto-single-gallery-img--hr ').length) {

            let imageBlock = $('.aheto-single-gallery-img--hr .aheto-single-gallery-img');
            let closePopup = $('.aheto-single-gallery-img--hr .aheto-single-gallery-popup .close');
            imageBlock.on('click', function () {
                let imageUrl = $(this).find('img').attr('src');

                $(this).next().find('img').attr('src', imageUrl);
                $(this).next().fadeIn();
            });
            closePopup.on('click', function () {
                $(this).parent().fadeOut();
            })
        }
    });

})(jQuery, window, document);