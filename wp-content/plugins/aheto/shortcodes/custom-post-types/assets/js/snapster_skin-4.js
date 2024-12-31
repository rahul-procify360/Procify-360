;(function ($, window, document, undefined) {
    "use strict";

    function snapster_romanize(num) {
        var lookup = {
            M: 1000,
            CM: 900,
            D: 500,
            CD: 400,
            C: 100,
            XC: 90,
            L: 50,
            XL: 40,
            X: 10,
            IX: 9,
            V: 5,
            IV: 4,
            I: 1
        }, roman = '', i;
        for (i in lookup) {
            while (num >= lookup[i]) {
                roman += i;
                num -= lookup[i];
            }
        }
        return roman;
    }

    function snapster_tooltip() {

        if ($('.aheto-cpt-article--snapster_skin-4').length) {

            let counter = 1;

            $('.aheto-cpt-article--snapster_skin-4 .aheto-cpt-article__title').each(function () {

                let title = $(this).attr('data-title');
                let number = snapster_romanize(counter);

                $(this).html(title + ' ' + number);

                counter++;
            });


            document.onmousemove = function (e) {

                if ($(e.target).hasClass('aheto-cpt-article--snapster_skin-4') || $(e.target).closest('.aheto-cpt-article--snapster_skin-4')) {
                    let x = (e.offsetX + 15) + 'px',
                        y = (e.offsetY + 15) + 'px';

                    $('.aheto-cpt-article--snapster_skin-4 .aheto-cpt-article__title').css({
                        'top': y,
                        'left': x
                    });
                }
            };


        }


        $('.aheto-cpt-article--snapster_skin-4 a').on('mouseenter', function (e) {
            e.preventDefault();
        });
    }


    $(window).on('load', function () {
        snapster_tooltip();
    });

    if (window.elementorFrontend) {
        snapster_tooltip();
    }


})(jQuery, window, document);