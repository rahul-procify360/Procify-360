;(function ($, window, document, undefined) {
    "use strict";

    function fixMapHeight(){

        if($('.wpb_wrapper .aheto-map').length){

            $('.wpb_wrapper .aheto-map').each(function () {

                let height = $(this).attr('data-height').length ? $(this).attr('data-height') : $(this).css('height');


                $(this).parent().height(height).closest('.wpb_wrapper').height(height);

            })

        }

        if($('.elementor-widget-wrap .aheto-map').length){

            $('.elementor-widget-wrap .aheto-map').each(function () {

                let height = $(this).attr('data-height').length ? $(this).attr('data-height') : $(this).css('height');


                $(this).parent().height(height)
                    .closest('.elementor-widget-container').height(height)
                    .closest('.elementor-widget').height(height)
                    .closest('.elementor-widget-wrap').height(height);

            })

        }

    }



    $( () => {

        fixMapHeight();

    });

    $(window).on('load', function () {

        fixMapHeight();

    });



})(jQuery, window, document);