;(function ($, window, document, undefined) {
    "use strict";

    const $isotope = $('.aheto-pricing--rela-isotope .aheto-pricing__content');

    if ( window.elementorFrontend ) {
        isotopeInit();
    }

    /* ISOTOPE INIT */
    function isotopeInit() {
        if ($isotope.length) {

            $isotope.each(function () {
                const layout  = $(this).attr('data-layout') || 'masonry';

                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    percentPosition: true,
                    layoutMode: layout,
                    masonry: {
                        columnWidth: '.js-isotope-box',
                        "gutter": 15
                    }
                })
            });
        }
    }

    /* ISOTOPE FILTER */
    $('[data-pricing-filter]').on('click', function (e) {
        e.preventDefault();

        const $this = $(this);

        const filterValue = $this.attr('data-pricing-filter');

        $isotope.isotope({
            filter: '.' + filterValue
        });
    });

    function initialFiltering() {
        let $firstFilterValue = $('[data-pricing-filter]').first().attr('data-pricing-filter');

        $isotope.isotope({
            filter: '.' + $firstFilterValue
        });
    }

    $(window).on('load', function () {
        initialFiltering();
        isotopeInit();
    });

    if ( window.elementorFrontend ) {
        initialFiltering();
    }

})(jQuery, window, document);