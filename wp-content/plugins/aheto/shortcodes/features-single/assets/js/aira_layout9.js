jQuery(document).ready(function($) {



    function hidedBlock() {
        $('.aheto-content-block--aira-with-background .aheto-content-block--bgImage').hover(
            function () {
                $(this).find('.aheto-content-block__info').slideDown(200);
            },
            function () {
                $(this).find('.aheto-content-block__info').slideUp(200);
            }
        );
    };


    $(window).on('load', function () {
        hidedBlock();
    });

    if ( window.elementorFrontend ) {
        hidedBlock();
    }
});

