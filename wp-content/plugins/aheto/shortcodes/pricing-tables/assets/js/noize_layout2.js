;(function ($, window, document, undefined) {
    "use strict";

    $('.aheto-pricing-tables--noize-lay2 .aheto-pricing-tables--noize-lay2__button').on('click', function (e) {

        e.preventDefault();

        let parent = $('.aheto-pricing-tables--noize-lay2-item').closest('.aheto-pricing-tables--noize-lay2-items');

        if ( parent.find('.hide-item').length > 4 ){
            parent.find('.hide-item').slice(0, 3).removeClass('hide-item');
        } else {
            parent.find('.hide-item').removeClass('hide-item');
            $(this).hide();
        }

    });

    $(window).on('load', function() {
        let checkItem = $('.aheto-pricing-tables--noize-lay2-item').closest('.aheto-pricing-tables--noize-lay2-items');

        checkItem.find('.hide-item').length == 0 ? $('.aheto-pricing-tables--noize-lay2 .aheto-pricing-tables--noize-lay2__button').hide() : $('.aheto-pricing-tables--noize-lay2 .aheto-pricing-tables--noize-lay2__button').show();
    });

})(jQuery, window, document);