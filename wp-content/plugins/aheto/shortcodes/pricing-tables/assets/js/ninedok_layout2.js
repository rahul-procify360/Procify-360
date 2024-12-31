;(function ($, window, document, undefined) {
    "use strict";

    const $isotope = $('.aheto-pricing--ninedok-isotope .aheto-pricing__content');


    $( () => {


        $('.aheto-pricing--ninedok-isotope [data-pricing-filter]').on('click', function (e) {
            e.preventDefault();

            const $this = $(this);

            const filterValue = $this.attr('data-pricing-filter');

            $isotope.isotope({
                filter: '.' + filterValue
            });
        });


        $(window).on('load', function () {
            isotopeInit()
            initialFiltering();
        })

    });

    function isotopeInit() {
        if ($isotope.length) {

            $isotope.each(function () {

                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    layoutMode: 'masonry',
                    percentPosition: true,
                    masonry: {
                        gutter: 15
                    }
                })
            });

        }
    }

    function initialFiltering() {
        let $firstFilterValue = $('[data-pricing-filter]').first().attr('data-pricing-filter');

        $isotope.isotope({
            filter: '.' + $firstFilterValue
        });
    }

    if (window.elementorFrontend) {
        isotopeInit();
        initialFiltering();

    }

})(jQuery, window, document);
