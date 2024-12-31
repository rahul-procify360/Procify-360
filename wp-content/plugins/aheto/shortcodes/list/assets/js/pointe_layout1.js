; (function ($, window, document, undefined) {
    "use strict";

    $('.aheto-list--pointe-table-links .aheto-link, .aheto-list--pointe-table-links .cs-btn').on('click', function (e) {

        e.preventDefault();
        let third_row = $('.aheto-list--pointe-table-links .aheto-list--row:nth-child(3)');
        if($(window).width() > 1231) {
            third_row.css('border-bottom', 'none');
        }
        
        let parent = $(this).closest('.aheto-list--pointe-table-links ');

        if (parent.find('.hide-item').length >= 3) {
            parent.find('.hide-item').slice(0, 2).removeClass('hide-item');
        } else {
            parent.find('.hide-item').removeClass('hide-item');
            $(this).hide();
        }

    });
    let third_row = $('.aheto-list--pointe-table-links .aheto-list--row:nth-child(3)');

    if($(window).width() < 1231) {
        if(third_row.length){
            third_row.css('border-bottom', '1px solid rgba(var(--ca-grey), .35)');
        }
    }else {
        if(third_row.length) {
            third_row.css('border-bottom', 'none');
        }
    }

    $(window).on('load', function () {
        let checkItem = $('.aheto-list--row').closest('.aheto-list--pointe-table-links ');
        checkItem.find('.hide-item').length == 0 ? $('.aheto-list--pointe-table-links .cs-btn').hide() : $('.aheto-list--pointe-table-links .cs-btn').show();
    });
})(jQuery, window, document);