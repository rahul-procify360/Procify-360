; (function ($, window, document, undefined) {
    "use strict";

    function snapster_article_load(){

        let docViewTop = $(window).scrollTop();
        let docViewBottom = docViewTop + $(window).height();

        if($('.aheto-cpt--mosaics .aheto-cpt-article--snapster_skin-3').length){

            $('.aheto-cpt--mosaics .aheto-cpt-article--snapster_skin-3').each(function () {

                let elemTop = $(this).offset().top;
                if (elemTop < docViewBottom) {
                    $(this).find('.aheto-cpt-article__img').addClass('show');
                }

            });
        }
    }

    $(window).on('load scroll', function () {
        snapster_article_load();
    });

    if ( window.elementorFrontend ) {
        snapster_article_load();
    }

})(jQuery, window, document);
