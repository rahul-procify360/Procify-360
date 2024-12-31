;
(function ($, window, document, undefined) {
    "use strict";

    // FUNCTION ON SCROLL PROGRESSBAR
    function progressBar() {
        if ($('#myBar').length)  {
            let winScroll                                = document.body.scrollTop || document.documentElement.scrollTop;
            let footerHeight                             = $('.wr-footer').outerHeight();
            let recentHeight                             = $('.wr-recent-single').outerHeight();
            let height                                   = document.documentElement.scrollHeight - document.documentElement.clientHeight - footerHeight - recentHeight;
            let scrolled                                 = (winScroll / height) * 100;
            document.getElementById("myBar").style.width = scrolled + "%";
        }
    }
    $(window).on('scroll', function() {
        progressBar();
    });
})(jQuery, window, document);