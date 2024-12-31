;(function ($, window, document, undefined) {

    'use strict';
    
    let autoplayInterval;

    function snapster_banner_slider_height() {

        if ($('.aheto-banner-slider--snapster-modern').length) {

            $('.aheto-banner-slider--snapster-modern').each(function () {

                let imageH = 0;
                let imageW = 0;

                $(this).find('.aheto-banner-slider__bgimg > div:first-of-type span').each(function () {

                    imageH = $(this).find('img').innerHeight() > imageH ? $(this).find('img').innerHeight() : imageH;
                    imageW = $(this).find('img').outerWidth() > imageW ? $(this).find('img').outerWidth() : imageW;

                });

                $(this).find('.snapster-full-min-height-js').css('height', imageH);

            });

        }
    }

    $(window).on('load resize orientationchange', function () {
        setTimeout(snapster_banner_slider_height, 100);

    });
    
    
    function snapster_slider_autoplay(banner_slider, elem) {
        banner_slider.find('label').removeClass('active');
        elem.addClass('active');

        const count = elem.prev().data('count');
        let styles = banner_slider.find('.aheto-banner-slider__bgimg div span:nth-child(' + count + ')').attr('style');
        banner_slider.find('.aheto-banner-slider__bgimg').attr('style', styles);

        setTimeout(function () {
            banner_slider.find('.aheto-banner-slider__text').removeClass('active');
            banner_slider.find('.aheto-banner-slider__text:nth-child(' + count + ')').addClass('active');

            banner_slider.find('.aheto-banner-slider__bgimg div span').removeClass('active');
            banner_slider.find('.aheto-banner-slider__bgimg div span:nth-child(' + count + ')').addClass('active');
        }, 100);
    }


    function snapster_banner_slider_pagination() {

        $('.aheto-banner-slider--snapster-modern').each(function () {
            const banner_slider = $(this);
            let banner_loop = $(this).find('.aheto-banner-slider__container').data('loop');
            let banner_autoplay = $(this).find('.aheto-banner-slider__container').data('autoplay');
            let banner_autoplay_speed = $(this).find('.aheto-banner-slider__container').data('autoplay-speed');

            banner_slider.find('.aheto-banner-slider__buttons-prev').on('click', function () {

                if (banner_slider.find('label.active').prev().prev().length) {
                    banner_slider.find('.aheto-banner-slider__buttons-next').removeClass('disabled');
                    banner_slider.find('label.active').prev().prev().click();
                    snapster_banner_slider_disable_button();
                } else if (banner_loop === 1) {
                    banner_slider.find('label:last-of-type').click();
                }

            });

            banner_slider.find('.aheto-banner-slider__buttons-next').on('click', function () {

                if (banner_slider.find('label.active').next().next().length) {
                    banner_slider.find('.aheto-banner-slider__buttons-prev').removeClass('disabled');
                    banner_slider.find('label.active').next().next().click();
                    snapster_banner_slider_disable_button();
                } else if (banner_loop === 1) {
                    banner_slider.find('label:first-of-type').click();
                }

            });

            banner_slider.find('label').on('click', function () {

                snapster_slider_autoplay(banner_slider, $(this));

            });

            let label_next;
            let label_first = banner_slider.find('label:first-of-type');

            if ( banner_autoplay === 1 && banner_autoplay_speed !== '' && banner_autoplay_speed !== 0 ) {

                banner_autoplay_speed = banner_autoplay_speed*1000;

                autoplayInterval = setInterval(function () {
                    if (banner_slider.find('label.active').next().next().length) {
                        banner_slider.find('.aheto-banner-slider__buttons-prev').removeClass('disabled');
                        label_next = banner_slider.find('label.active').next().next();

                        snapster_slider_autoplay(banner_slider, label_next);
                        snapster_banner_slider_disable_button();
                    } else if (banner_loop === 1) {
                        snapster_slider_autoplay(banner_slider, label_first);
                    }else{
                        clearInterval(autoplayInterval);
                    }

                }, banner_autoplay_speed );

            }


        });

    }


    function snapster_banner_slider_disable_button() {
        $('.aheto-banner-slider--snapster-modern').each(function () {
            const banner_slider = $(this);
            const banner_loop = $(this).find('.aheto-banner-slider__container').data('loop');

            if (banner_slider.find('label:first-of-type').hasClass('active') && banner_loop === 0) {
                banner_slider.find('.aheto-banner-slider__buttons-prev').addClass('disabled');
            }

            if (banner_slider.find('label:last-of-type').hasClass('active') && banner_loop === 0) {
                banner_slider.find('.aheto-banner-slider__buttons-next').addClass('disabled');
            }

        });
    }



    $(window).on('load', function () {
        clearInterval(autoplayInterval);
        snapster_banner_slider_pagination();
        snapster_banner_slider_disable_button();
    });


    if (window.elementorFrontend) {
        clearInterval(autoplayInterval);
        setTimeout(snapster_banner_slider_height, 100);
        snapster_banner_slider_pagination();
        snapster_banner_slider_disable_button();
    }

})(jQuery, window, document);