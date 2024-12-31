;(function ($, window, document, undefined) {
    'use strict';

   function sliderWidth(){
       if($('.aheto-banner-slider--prego .aheto-banner-slider__slider').length){
           let elWidth = $('.aheto-banner-slider--prego .aheto-banner-slider__slider').width();
           $('.swiper-slide').width(elWidth).height(elWidth);

           if($('.aheto-banner-slider--prego .aheto-banner-slider__content').length){
               let elheight = $('.aheto-banner-slider--prego .aheto-banner-slider__slider').height();
               $('.aheto-banner-slider--prego .aheto-banner-slider__content').css('min-height', elheight);
           }
       }
   }

   $(window).on('load resize orientationchange', function (){
       sliderWidth();
   });

})(jQuery, window, document);