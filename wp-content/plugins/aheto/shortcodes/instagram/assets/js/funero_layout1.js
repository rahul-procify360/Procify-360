;(function ($, window, document) {
    "use strict";

        const instagram = $('.aheto-instagram--funero-list .js-instagram');

        if (instagram.length) {
            instagram.each(function () {
                const token = $(this).attr('data-token');
                const size  = 'small';
                const max   =  6;

                $.fn.spectragram.accessData = {
                    accessToken: token
                };

                $(this).spectragram('getUserFeed', {
                    size: size,
                    max: max,
                    accessToken: token
                });
            });
        }

})(jQuery, window, document);
