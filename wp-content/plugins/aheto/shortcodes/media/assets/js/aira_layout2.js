;(function ($, window, document, undefined) {
    "use strict";

    function aira_popup () {
        if ( $('.aheto_media--aira-gall .aheto_media__img').length ) {


            $('.aheto_media__img').magnificPopup({
                delegate: 'div',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0,1]
                },
                callbacks: {
                    beforeOpen: function() {
                        jQuery('body').css('overflow','hidden');
                        isBlocked = true;
                    },
                    beforeClose: function() {
                        jQuery('body').css({
                            'overflow': 'auto',
                        });
                        isBlocked = false;
                    }
                }
            });
        }
    }

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

    document.addEventListener('touchmove', function(e) {
        if (isBlocked) {
            e.preventDefault();
        }
    }, hasPassiveEvents ? {
        passive: false
    } : undefined);




    $(window).on('load', function() {
        aira_popup();
    });

})(jQuery, window, document);