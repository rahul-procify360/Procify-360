;(function ($, window, document, undefined) {
    "use strict";

    function noize_gallery () {
        if ( $('.aheto_media--noize-img').length ) {
            $('.aheto_media--noize-img').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
                masonry: {
                    // use outer width of grid-sizer for columnWidth
                    columnWidth: '.grid-sizer'
                }
            })
        }
    }

    $('.aheto_media--noize-btn .cs-btn').on('click', function (e) {
        e.preventDefault();

        let parent = $('.grid-item').closest('.aheto_media--noize-img');

        if ( parent.find('.hide-item').length >= 6 ){
            parent.find('.hide-item').slice(0, 6).removeClass('hide-item');
            $(this).hide();
        } else {
            parent.find('.hide-item').removeClass('hide-item');
            $(this).hide();
        }

        noize_gallery();
    });

    $(window).on('load resize orientationchange', function() {
        noize_gallery();
    });

    $(window).on('load', function() {

        let checkItem = $('.grid-item').closest('.aheto_media--noize-img');

        checkItem.find('.hide-item').length == 0 ? $('.aheto_media--noize-btn .cs-btn').hide() : $('.aheto_media--noize-btn .cs-btn').show();
    });

})(jQuery, window, document);
