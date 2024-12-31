;(function ($, window, document, undefined) {
    "use strict";

    const $isotope = $('.aheto-pricing--ewo-isotope .aheto-pricing__content');

    // ISOTOPE INIT

    $(window).on('load', function () {
        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    percentPosition: true,
                    masonry: {
                        columnWidth: '.js-isotope-box',
                        "gutter": 15
                    }
                })
            });
        }
    });

    // ISOTOPE FILTER
    $('.aheto-pricing--ewo-isotope__list[data-pricing-filter]').on('click', function (e) {
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

    initialFiltering();

})(jQuery, window, document);