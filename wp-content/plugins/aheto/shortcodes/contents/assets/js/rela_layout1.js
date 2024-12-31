;(function ($, window, document, undefined) {
    'use strict';

        const $isotope = $('.rela-js-accordion-parent');

        /* ISOTOPE INIT */
        $(window).on('load', () => {
            if ($isotope.length) {

                $isotope.each(function () {

                    let $isotope_parent = $(this);

                    $(this).isotope({
                        itemSelector: '.rela-js-accordion-item',
                        layoutMode: 'masonry',
                        percentPosition: true,
                        masonry: {
                            gutter: 10
                        }
                    })


                    $isotope_parent.find('.rela-js-accordion').on('click', function (e) {
                        e.preventDefault();

                        let timerId;

                        if ($(this).parent().find('.rela-js-accordion-text').is(':hidden')) {
                            timerId = setInterval(() => $isotope_parent.isotope('layout'), 50);

                        } else {
                            setTimeout(() => {
                                $isotope_parent.isotope('layout');
                            }, 365);
                        }

                        $(this).parent().find('.rela-js-accordion-text').slideToggle(function () {
                            if ($(this).is(':hidden')) {
                                $(this).parent().removeClass('is-open')
                            } else {
                                $(this).parent().addClass('is-open');
                                clearInterval(timerId);
                            }
                        });

                        if (!$(this).closest('.rela-js-accordion-parent').data('multiple')) {
                            $(this).parent().siblings().removeClass('is-open').find('.rela-js-accordion-text').hide(350);
                        }
                    });

                });

            }

        });

})(jQuery, window, document);
