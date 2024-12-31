!function(t){function e(e,n,i,r){var a=e.text(),c=a.split(n),s="";c.length&&(t(c).each(function(t,e){s+='<span class="'+i+(t+1)+'" aria-hidden="true">'+e+"</span>"+r}),e.attr("aria-label",a).empty().append(s))}var n={init:function(){return this.each(function(){e(t(this),"","char","")})},words:function(){return this.each(function(){e(t(this)," ","word"," ")})},lines:function(){return this.each(function(){var n="eefec303079ad17405c889e092e105b0";e(t(this).children("br").replaceWith(n).end(),n,"line","")})}};t.fn.lettering=function(e){return e&&n[e]?n[e].apply(this,[].slice.call(arguments,1)):"letters"!==e&&e?(t.error("Method "+e+" does not exist on jQuery.lettering"),this):n.init.apply(this,[].slice.call(arguments,0))}}(jQuery);

;(function ($, window, document, undefined) {

    'use strict';

    $(document).ready(function() {
        $(".aheto-banner-slider--snapster-creative .aheto-banner__title").lettering();
    });

    let a = 0;
    $(document).ready(function() {
        animationStart();
        $('.aheto-banner-slider--snapster-creative .swiper-button-next').append('<span></span>');
        $('.aheto-banner-slider--snapster-creative .swiper-button-prev').append('<span></span>');
    }, 1000);

    $('.aheto-banner-slider--snapster-creative .swiper-button-next, .aheto-banner-slider--snapster-creative .swiper-button-prev').click(function() {
        if (a === 0) {
            a++;
            setTimeout(animation, 1000);
        }
    });


    function animation() {
        var title1 = new TimelineMax();
        title1.staggerFromTo(".aheto-banner-slider--snapster-creative .swiper-slide-visible .aheto-banner__title span", 0.5,
            {ease: Back.easeOut.config(1.2), opacity: 0, bottom: -40},
            {ease: Back.easeOut.config(1.2), opacity: 1, bottom: 0}, 0.03);
        a = 0;
    }
    function animationStart() {
        var title1 = new TimelineMax();
        title1.staggerFromTo(".aheto-banner-slider--snapster-creative .swiper-slide .aheto-banner__title span", 0.5,
            {ease: Back.easeOut.config(1.2), opacity: 0, bottom: -40},
            {ease: Back.easeOut.config(1.2), opacity: 1, bottom: 0}, 0.03);
    }



})(jQuery, window, document);
