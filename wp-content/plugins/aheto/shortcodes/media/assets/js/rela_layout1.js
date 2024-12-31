; (function ($, window, document, undefined) {
    "use strict";

    $(window).on('load', function () {
        let imageBlock = $('.aheto-single-gallery-img');
        let closePopup = $('.aheto-single-gallery-popup .close');
        let closePopupOut = $('.aheto-single-gallery-popup_overlay');
        imageBlock.on('click', function () {
            let imageUrl = $(this).find('img').attr('src');

            $(this).next().find('img').attr('src', imageUrl);
            $(this).next().fadeIn();
            $('body').css("overflow", "hidden");
            isBlocked = true;
        });

        closePopup.on('click', function () {
            $(this).parent().fadeOut();
            $('body').css("overflow", "unset");
            isBlocked = false;
        })
        closePopupOut.on('click', function () {
            $('.aheto-single-gallery-popup').fadeOut();
            $('body').css("overflow", "unset");
            isBlocked = false;
        })


        let isBlocked = false;
        let hasPassiveEvents = false;
        if (typeof window !== 'undefined') {
            let passiveTestOptions = {
                get passive() {
                    hasPassiveEvents = true;
                    return undefined;
                }
            };
            window.addEventListener('testPassive', null, passiveTestOptions);
            window.removeEventListener('testPassive', null, passiveTestOptions);
        }

        document.addEventListener('touchmove', function (e) {
            if (isBlocked) {
                e.preventDefault();
            }
        }, hasPassiveEvents ? {
            passive: false
        } : undefined);


    });
})(jQuery, window, document);