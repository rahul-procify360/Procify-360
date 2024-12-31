;(function ($, window, document, undefined) {
    'use strict';
    
    function single_img(){
        const dataWidth = jQuery('.aheto-media--moovit-responsive .aheto-single-img').data('width');

        jQuery('.aheto-media--moovit-responsive .aheto-single-img').each(function () {
            if(jQuery(window).width() < dataWidth) {
                jQuery(this).fadeOut();
            } else {
                jQuery(this).fadeIn();
            }
        });
    }


    jQuery(window).on('load resize orientationchange', function () {
        single_img();

    });

})(jQuery, window, document);