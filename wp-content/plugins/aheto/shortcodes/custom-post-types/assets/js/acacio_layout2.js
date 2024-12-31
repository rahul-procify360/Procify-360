;(function ($, window, document, undefined) {
    'use strict';

    $(window).on('load', function () {
        const $isotope = $('.aheto-cpt--acacio-metro ');

        /* ISOTOPE INIT */

        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.aheto-cpt-article--acacio_skin-6',
                    percentPosition: true,
                    layoutMode: 'masonry',
                    masonry: {
                        columnWidth: '.aheto-cpt--acacio-metro-sizer',
                    }
                })
            });

        }
    });

})(jQuery, window, document);