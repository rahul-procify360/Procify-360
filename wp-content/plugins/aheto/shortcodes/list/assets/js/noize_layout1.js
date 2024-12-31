;(function ($, window, document, undefined) {
    "use strict";

    $('.aheto-list--noize .aheto-list--noize-links-button .aheto-btn, .aheto-list--noize .aheto-list--noize-links-button .cs-btn').on('click', function (e) {
        e.preventDefault();

        let parent = $(this).closest('.aheto-list--noize');

        if ( parent.find('.hide-item').length >= 5 ){
            parent.find('.hide-item').slice(0, 5).removeClass('hide-item');
        } else {
            parent.find('.hide-item').removeClass('hide-item');
            $(this).hide();
        }
    });

    $(window).on('load', function() {
        let checkItem = $('.aheto-list--noize--row').closest('.aheto-list--noize');

        checkItem.find('.hide-item').length == 0 ? $('.aheto-list--noize .cs-btn').hide() : $('.aheto-list--noize .cs-btn').show();
    });

})(jQuery, window, document);