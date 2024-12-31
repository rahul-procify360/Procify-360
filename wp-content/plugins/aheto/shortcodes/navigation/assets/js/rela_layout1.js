;(function ($, window, document, undefined) {

    const relaHeader = $('.aheto-header--fixed .main-header--rela-main');
    let relaWidgetsTop = 0;


    $(window).on('load', function () {
        relaWidgetsTop = $('.main-header__widget-box').outerHeight() - 34;
    });

    $(window).on('scroll load', function () {

        let windowTop = $(window).scrollTop();

        if (relaHeader.length) {

            if (windowTop >= relaWidgetsTop) {
                relaHeader.addClass('rela-header-scroll');
                $('.aheto-header--fixed').removeClass('rela-no-fixed');
            } else {
                $('.aheto-header--fixed').addClass('rela-no-fixed');
                relaHeader.removeClass('rela-header-scroll');
            }
        }
    });

})(jQuery, window, document);
