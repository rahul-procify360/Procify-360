;(function ($, window, document, undefined) {

    "use strict";

    function karma_political_gallery () {
        if ( $('.aheto_media--karma-political-simple .aheto_media--karma-political-img').length ) {
            $('.aheto_media--karma-political-img').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
                masonry: {
                    // use outer width of grid-sizer for columnWidth
                    columnWidth: '.grid-sizer'
                }
            })
        }
    }

    function karma_political_popup() {
        if ($('.aheto_media--karma-political-simple .aheto_media--karma-political-img').length) {
            $('.aheto_media--karma-political-img').magnificPopup({
                delegate: 'a',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                }
            });
        }
    }

    $(window).on('load resize orientationchange', function() {
        karma_political_gallery();
    });

    $(window).on('load', function() {
        karma_political_popup();
    });

})(jQuery, window, document);