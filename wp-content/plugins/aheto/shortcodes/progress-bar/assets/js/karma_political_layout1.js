;(function ($, window, document) {
    "use strict";

    let lengthCounter = $('.aheto-counter--karma-political-number').length;

    for (let i = 0; i < lengthCounter; i++ ) {
        let getContainer = $('.aheto-counter--karma-political-number').eq(i).find('.aheto-counter__number');
        let getNumb = $('.aheto-counter--karma-political-number').eq(i).find('.aheto-counter__number').html();

        counterFunction(getNumb, getContainer);
    }

    function counterFunction(count, container) {
        if ( count >= 1000 ) {
            let mathAlg = Math.round((count / 1000) * 10) / 10 + 'k';

            return container.html(mathAlg);
        } else {
            return count;
        }
    }

})(jQuery, window, document);