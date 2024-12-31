;(function ($, window, document, undefined) {

    "use strict";

    let getLengthItem = $('.aheto-cpt--karma-political__simple .aheto-cpt__blog').attr('data-item-limit-showed');
    let checkItem = $('.aheto-cpt__blog').closest('.aheto-cpt--karma-political__simple');

    $('.aheto-cpt--karma-political__simple .aheto-cpt-article__load-button .aheto-btn').on('click', function(e) {
        e.preventDefault();

        let parent = $(this).closest('.aheto-cpt--karma-political__simple');

        if ( parent.find('.aheto-cpt__blog').not('.showed').length >= getLengthItem ) {
            parent.find('.aheto-cpt__blog').not('.showed').slice(0, getLengthItem).addClass('showed').removeClass('hide-item');
            checkItem.find('.hide-item').length == 0 ? $(this).hide() : null;
        } else {
            parent.find('.aheto-cpt__blog').not('.showed').addClass('showed');

            $(this).hide();
        }

    });

    $(window).on('load', function() {
        $('.aheto-cpt__blog').length >= getLengthItem ? $('.aheto-cpt__blog').slice(0, getLengthItem).addClass('showed').removeClass('hide-item') : null;

        checkItem.find('.hide-item').length == 0 ? $('.aheto-cpt--karma-political__simple .aheto-cpt-article__load-button .aheto-btn').hide() : $('.aheto-cpt--karma-political__simple .aheto-cpt-article__load-button .aheto-btn').show();
    });

})(jQuery, window, document);