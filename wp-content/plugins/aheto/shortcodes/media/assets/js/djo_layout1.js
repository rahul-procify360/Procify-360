;(function ($, window, document, undefined) {
    "use strict";

    /**
     * Prevent scroll on mobile devices
     */

    let isBlocked = false;
    let hasPassiveEvents = false;
    if (typeof window !== 'undefined') {
        const passiveTestOptions = {
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

    window.addEventListener('load', () => {
        if ($('.aheto-gallery--djo-gallery').length) {
            $('.aheto-gallery--djo-gallery .js-gallery-wrap').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                },
                removalDelay: 500,
                callbacks: {
                    beforeOpen: function() {
                        this.st.image.markup = this.st.image.markup.replace('mfp-figure', 'mfp-figure mfp-with-anim');
                        this.st.mainClass = this.st.el.attr('data-effect');
                        isBlocked = true;
                    },
                    beforeClose: () => {
                        isBlocked = false;
                    }
                },
                closeOnContentClick: true,
                midClick: true
            });
        }
    })
})(jQuery, window, document);