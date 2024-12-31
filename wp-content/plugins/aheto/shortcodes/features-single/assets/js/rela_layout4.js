;(function ($, window, document, undefined) {
    'use strict';

    let calcBlock = '.aheto-features--rela-packages .aheto-features-block__wrap';

    function windowSize() {

        if ($(calcBlock).length) {
            if ($(window).width() >= 753) {
                let max_col_height = 0;
                $(calcBlock).each(function () {
                    if ($(this).height() > max_col_height) {
                        max_col_height = $(this).height();
                    }
                });
                $(calcBlock).height(max_col_height);
            }
        }
    }


    $(window).on('load', function () {
        windowSize();
    });

    $(window).on('resize onorientationchange', function () {
        $(calcBlock).height('unset');
        setTimeout(windowSize, 50);
    });


})(jQuery, window, document);





