;(function ($, window, document, undefined) {
    'use strict';

    $(window).on('load', function () {
        const titles = $('.aheto-cpt__list .aheto-cpt-article--acacio_skin-7 .aheto-cpt-article__title > a');

        $(titles).each(function(index, element) {
            let heading = $(element), word_array, last_word, first_part;

            word_array = heading.html().split(/\s+/); // split on spaces
            last_word = word_array.pop();             // pop the last word
            first_part = word_array.join(' ');        // rejoin the first words together

            heading.html([first_part, ' <span>', last_word, '</span>'].join(''));
        });

    });

})(jQuery, window, document);

