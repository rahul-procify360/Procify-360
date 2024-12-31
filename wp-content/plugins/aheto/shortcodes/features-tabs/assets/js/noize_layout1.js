;(function ($, window, document, undefined) {
    "use strict";

    let players = [];

    function getUrls() {
        let urls = $('.aheto--noize-features-tabs__gallery-thumbs .aheto--noize-features-tabs__image');
        let links = [];

        urls.each(function () {
            links.push($(this).data('url'));
        });

        return links;
    }

    let Youtube = (function () {
        let urls = $('.aheto--noize-features-tabs__gallery-thumbs .aheto--noize-features-tabs__image');
        let previewsUrls = $('.aheto--noize-features-tabs__gallery-top .swiper-slide');
        let video, regExp, results;

        let getThumb = function (url) {
            if (url === null) {
                return '';
            }

            for (let i = 0; i < url.length; i++) {
                regExp  = /^.*(?:(?:youtu\.be\/|v\/|vi\/|u\/\w\/|embed\/)|(?:(?:watch)?\?v(?:i)?=|\&v(?:i)?=))([^#\&\?]*).*/;
                results = url[i].match(regExp);
                video   = (results === null) ? url : results[1];

                $(urls).eq(i).css('background', 'url(https://i3.ytimg.com/vi/' + video + '/maxresdefault.jpg)');
                $(previewsUrls).children('div').eq(i).css('background', 'url(https://i3.ytimg.com/vi/' + video + '/maxresdefault.jpg)');
            }
        };

        return {
            thumb: getThumb
        };
    }());

    let thumb = Youtube.thumb( getUrls() );

    window.onYouTubeIframeAPIReady = function() {

        // each all iframe
        $('.aheto--noize-features-tabs__gallery-top iframe').each(function(i) {

            players[i] = new YT.Player(this, {
                events: {
                    'onReady': function (event) {

                        setTimeout(function(){
                            videoGallery();

                            $('.aheto--noize-features-tabs__video-duration-top').eq(i).html( formatTime( $(players)[i].getDuration() - 1 ) );
                            $('.aheto--noize-features-tabs__video-duration-thumbs').eq(i).html( formatTime( $(players)[i].getDuration() - 1 ) );
                        }, 300);


                        $('.aheto--noize-features-tabs__gallery-top .aheto--noize-features-tabs__iframe-previews').on('click', function() {
                            let iframeIndex = $(this).parent().index();

                            $(this).hide();

                            players[iframeIndex].playVideo();
                        });
                    }
                }

            });

        });

    }


    function videoGallery() {
        if($('.aheto--noize-features-tabs').length){
            let counter = 0;

            $('.aheto--noize-features-tabs').each(function () {
                let parent = $(this);

                if(parent.find('.aheto--noize-features-tabs__gallery-thumbs').length){

                    parent.find('.aheto--noize-features-tabs__gallery-thumbs').addClass('noize-gallery-thumbs-' + counter);

                    let galleryThumbs = new Swiper('.noize-gallery-thumbs-' + counter, {
                        spaceBetween: 5,
                        slidesPerView: 'auto',
                        direction: 'vertical',
                        freeMode: true,
                        watchSlidesVisibility: true,
                        watchSlidesProgress: true,
                        scrollbar: {
                            el: '.swiper-scrollbar',
                        },
                        scrollbarHide: true,
                        mousewheel: true
                    });

                    galleryThumbs.on('slideChange', function () {
                        // each all iframe
                        $('.aheto--noize-features-tabs__gallery-top iframe').each(function(i) {
                            players[i].pauseVideo();
                        });
                    });

                    if(parent.find('.aheto--noize-features-tabs__gallery-top').length){

                        parent.find('.aheto--noize-features-tabs__gallery-top').addClass('noize-gallery-top-' + counter);

                        let galleryTop = new Swiper('.noize-gallery-top-' + counter, {
                            spaceBetween: 0,
                            slidesPerView: 1,
                            thumbs: {
                                swiper: galleryThumbs,
                            },
                            breakpoints: {
                                1199: {
                                    slidesPerView: 1,
                                }
                            },
                            scrollbar: {
                                el: '.swiper-scrollbar',
                            },
                            scrollbarHide: true,
                        });

                        galleryTop.on('slideChange', function () {
                            // each all iframe
                            $('.aheto--noize-features-tabs__gallery-top iframe').each(function(i) {
                                players[i].pauseVideo();
                            });
                        });
                    }
                }

                counter++;
            });
        }
    }

    function formatTime(time) {
        let hours   = Math.floor(time / 3600);
        let minutes = Math.floor((time - (hours * 3600)) / 60);
        let seconds = time - (hours * 3600) - (minutes * 60);

        seconds = Math.round(seconds * 100 ) / 100;

        let result;

        if (hours == 0) {
            result = (minutes);
            result += ":" + (seconds  < 10 ? "0" + seconds : seconds);
        } else {
            result = (hours);
            result += ":" + (minutes);
            result += ":" + (seconds  < 10 ? "0" + seconds : seconds);
        }

        return result;
    }


    $(window).on('load resize orientationchange', function () {
        videoGallery();
    });

})(jQuery, window, document);