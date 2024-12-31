;(function ($) {

    'use strict';

    function initHover() {
        if ($('.aheto-cpt-article--snapster_skin-6 .aheto-cpt-article__inner').length) {
            let heightBlock = parseInt($(".aheto-cpt-article__img").css("padding-bottom"));
            let heightNetworks = $( ".aheto-cpt-article--snapster_skin-6 .aheto-cpt-article__inner" ).find(".aheto-cpt-article__title");
            heightNetworks.css({
                minWidth: heightBlock,
            });
        }
    }


    $(window).on('load resize orientationchange', function () {
        initHover()
    });

})(jQuery, window, document); 