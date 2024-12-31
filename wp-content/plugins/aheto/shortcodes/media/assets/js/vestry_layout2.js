; (function ($, window, document, undefined) {
    "use strict";

    function vestry_gallery() {
        if ($('.aheto-vestry-gallery-img').length) {
            $('.aheto-vestry-gallery-img').isotope({
                itemSelector: '.grid-item',
                percentPosition: true,
                masonry: {
                    columnWidth: '.grid-sizer'
                }
            })
        }

    }

    function vestry_popup() {
        if ($('.aheto-vestry-gallery-img').length) {
            $('.aheto-vestry-gallery-img').magnificPopup({
                delegate: 'figure',
                type: 'image',
                gallery: {
                    enabled: true,
                    navigateByImgClick: true,
                    preload: [0, 1]
                }
            });
        }
    }

    function showGallery() {
        let parent = $('.grid-item').closest('.aheto-vestry-gallery-img');

        if (parent.find('.hide-item').length >= 6) {
            parent.find('.hide-item').slice(0, 6).removeClass('hide-item');
        } else {
            parent.find('.hide-item').removeClass('hide-item');
        }
    }

    showGallery();

    $(window).on('load resize orientationchange', function () {
        vestry_gallery();
    });

    $(window).on('load', function () {
        vestry_popup();

        let checkItem = $('.grid-item').closest('.aheto-vestry-gallery-img');

        checkItem.find('.hide-item').length == 0 ? $('.aheto-vestry-gallery-button').hide() : $('.aheto-vestry-gallery-button').show();
    });

})(jQuery, window, document);
