jQuery(document).ready(function($) {


    $(window).on('load', function () {
        $('.aheto-cpt-article--aira_skin-3 .aheto-cpt-article__inner').hover(
            function () {
                $(this).find('.aheto-cpt-article__excerpt').slideDown(200);
            },
            function () {
                $(this).find('.aheto-cpt-article__excerpt').slideUp(200);
            }
        );
    });
});
