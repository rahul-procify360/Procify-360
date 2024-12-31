;(function ($, window, document, undefined) {

    "use strict";

    const $isotope = $('.aheto-pricing--karma-marketing-isotope .aheto-pricing__content');

    if ( window.elementorFrontend )  {
        isotopeInit();
    }

    $( () => {
        isotopeInit();

        $('.aheto-pricing--karma-marketing-isotope .aheto-pricing__list-item a')
            .on('click', function () {
                $('.aheto-pricing__list-item a')
                    .removeClass('active');
                $(this)
                    .addClass('active');
                var filterValue = $(this).attr('data-pricing-filter');
                $isotope.isotope({
                    filter: filterValue
                });
            });
    });

    function isotopeInit() {
        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    layoutMode: 'masonry',
                    percentPosition: true,
                    masonry: {
                        gutter: 0
                    }
                })
            });

        }
    }

    function initialFiltering() {
        let $firstFilterValue = $('.aheto-pricing--karma-marketing-isotope [data-pricing-filter]').first().attr('data-pricing-filter');

        if($isotope.length){
            $isotope.isotope({
                filter:  $firstFilterValue
            });
        }
    }

    $(window).on('load', function () {
        initialFiltering();
    });

})(jQuery, window, document);
