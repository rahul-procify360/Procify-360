;(function ($, window, document, undefined) {
    "use strict";

    const $isotope = $('.aheto-contents--noize-isotope .aheto-contents__content');


    if ( window.elementorFrontend ) {
        isotopeInit();
    }

    $( () => {
        $(window).on('load', () => {
            isotopeInit();
        });

        $('.aheto-contents__list-item a').on('click', function () {
            $('.aheto-contents__list-item a').removeClass('active');
            $(this).addClass('active');

            let filterValue = $(this).attr('data-contents-filter');

            if ($isotope.length) {
                $isotope.isotope({
                    filter: filterValue
                });
            }
        });
    });

    function isotopeInit() {
        if ($isotope.length) {
            $isotope.each(function () {
                $(this).isotope({
                    itemSelector: '.js-isotope-box',
                    layoutMode: 'masonry',
                    percentPosition: true,
                    straightAcross: {
                        gutter: 15
                    }
                })
            });
        }
    }

})(jQuery, window, document);