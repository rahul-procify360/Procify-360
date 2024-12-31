;(function ($, window, document, undefined) {
    'use strict';


    let supportsTouch = 'ontouchstart' in window || navigator.msMaxTouchPoints;

    if($('.aheto-contents__prego .aheto-contents__point').length){

        if(supportsTouch){
            $('.aheto-contents__prego .aheto-contents__point').on('click', function (){
                let id = $(this).data('id');
                let parent = $(this).closest('.aheto-contents__prego');

                parent.find('.aheto-contents__point:not([data-id='+ id +'])').removeClass('active');
                parent.find('.aheto-contents__item:not([data-id='+ id +'])').removeClass('active');

                $(this).toggleClass('active');
                parent.find('.aheto-contents__item[data-id='+ id +']').toggleClass('active');
            });
        }

        function hoverEl(el, event = true){
            let id = el.data('id');
            let parent = el.closest('.aheto-contents__prego');
            if(event){
                el.addClass('active');
                parent.find('.aheto-contents__item[data-id='+ id +']').addClass('active');
            }else{
                el.removeClass('active');
                parent.find('.aheto-contents__item[data-id='+ id +']').removeClass('active');
            }
        }

        if(!supportsTouch){

            $('.aheto-contents__prego .aheto-contents__point').hover(function (){
                hoverEl($(this), true);
            }, function (){
                hoverEl($(this), false);
            });
        }
    }

})(jQuery, window, document);