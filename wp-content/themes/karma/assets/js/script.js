;(function ($, window, document, undefined) {
    'use strict';

    const $WIN = $(window);
    const BREAKPOINTS = {
        zero: 0,
        xs: 575,
        sm: 768,
        md: 992,
        lg: 1200
    };
    const swipers = [];
    const swipersDOM = document.getElementsByClassName('swiper-container');


    if (typeof fitVids === 'function') {
        $('body').fitVids({ignore: '.vimeo-video, .youtube-simple-wrap iframe, .iframe-video.for-btn iframe, .post-media.video-container iframe'});
    }

    /*=================================*/
    /* PAGE CALCULATIONS */
    /*=================================*/

    if (typeof pageCalculations !== 'function') {

        var winW, winH, pageCalculations, onEvent = window.addEventListener;

        pageCalculations = function (func) {

            winW = window.innerWidth;
            winH = window.innerHeight;

            if (!func) return;

            onEvent('load', func, true); // window onload
            onEvent('resize', func, true); // window resize
            onEvent("orientationchange", func, false); // window orientationchange

        }; // end pageCalculations

        pageCalculations(function () {
            pageCalculations();
        });
    }

    $(window).on('load', function () {
        if ($('.karma-preloader').length) {
            $('.karma-preloader').fadeOut(400);
        }

        wpc_add_img_bg('.js-bg');
    });

    function calcPaddingMainWrapper() {

        if ($('.karma-footer').length) {
            var footer = $('.karma-footer');
            var paddValue = footer.outerHeight();

            footer.bind('heightChange', function () {
                $('body').css('padding-bottom', paddValue);

            });

            footer.trigger('heightChange');
        }
    }

    function blogIsotope() {
        if ($('.karma-search__items').length) {
            $('.karma-search__items').each(function () {
                var self = $(this);
                self.isotope({
                    itemSelector: '.karma-search__item',
                    layoutMode: 'masonry',
                    masonry: {
                        columnWidth: '.karma-search__item',
                        'gutter' : 30
                    }
                });
            });
        }
    }

    function wpc_add_img_bg(img_sel, parent_sel) {
        if (!img_sel) {
            return false;
        }

        var $parent, $imgDataHidden, _this;
        $(img_sel).each(function () {
            _this = $(this);
            $imgDataHidden = _this.data('s-hidden');
            $parent = _this.closest(parent_sel);
            $parent = $parent.length ? $parent : _this.parent();
            $parent.css('background-image', 'url(' + this.src + ')').addClass('s-back-switch');
            if ($imgDataHidden) {
                _this.css('visibility', 'hidden');
                _this.show();
            } else {
                _this.hide();
            }
        });
    }

    function adminBarPositionFix() {
        if ($('#wpadminbar').length) {
            $('#wpadminbar').css('position', 'fixed');
        }
    }

    function errorPageHeight() {
        if ($('.karma-hst').length) {
            let adminBar = 0;
            if ($('#wpadminbar').length) {
                adminBar = $(window).width() && $('#wpadminbar').length > 782 ? 32 : 46;
            }
            let headerH = $('.karma-header--wrap').length ? $('.karma-header--wrap').outerHeight() : 0;
            $('.karma-hst').css('margin-top', headerH - 1);
            $('.karma-st').css('top', headerH + 15 + adminBar);
        }
        if ($('.karma-error--wrap').length) {
            var footerH = $('.karma-footer').length ? $('.karma-footer').outerHeight() : 0,
                headerH = $('.karma-header--wrap').length ? $('.karma-header--wrap').outerHeight() : 0,
                errorH = $(window).height() - footerH - headerH;

            $('.karma-error--wrap').css('min-height', errorH);
        }
    }


    $('.karma-blog--single__comments-button').on('click', function () {

        $(this).toggleClass('active');
        if ($('.karma-blog--single__comments').length) {
            $('.karma-blog--single__comments').slideToggle();
        }
    });


    $(window).on('load resize orientationchange', function () {
        calcPaddingMainWrapper();
        setTimeout(blogIsotope, 200);
        adminBarPositionFix();
        errorPageHeight();
    });

    /* ============================ */
    /* SWIPER */
    /* ============================ */

    const initSwiperElement = (_this, key) => {
        const index = `swiper-unique-${key}`;

        if (typeof _this === 'undefined') {
            return false;
        }

        _this.classList.add(index);
        _this.setAttribute('id', index);

        /* ----- ARROWS ------ */
        const arrows = !!_this.getAttribute('data-arrows');
        const $parent = $(_this).parent();
        const arrowPrev = arrows ? $parent.parent().find('.swiper-button-prev') : $parent.find('.swiper-button-prev');
        const arrowNext = arrows ? $parent.parent().find('.swiper-button-next') : $parent.find('.swiper-button-next');

        /* ----- PAGINATION ------ */
        const paginationEl = $parent.find('.swiper-pagination');

        if (paginationEl) {
            paginationEl.addClass('swiper-pagination-' + index);
        }


        /* ----- GET PARAMS ----- */
        const speed = +_this.getAttribute('data-speed') || 500;
        const initialSlide = +_this.getAttribute('data-initial_slide') || 0;
        const autoplayDelay = +_this.getAttribute('data-autoplay') || 0;
        const spaceBetween = +_this.getAttribute('data-spaces') || 0;
        const direction = _this.getAttribute('data-direction') || 'horizontal';
        const effect = _this.getAttribute('data-effect') || 'slide';
        const loop = !!_this.getAttribute('data-loop');
        const slideToClickedSlide = !!_this.getAttribute('data-slideToClickedSlide');
        const centeredSlides = !!_this.getAttribute('data-centeredSlides');
        const paginationType = _this.getAttribute('data-pagination-type') || 'bullets';
        const autoHeight = !!_this.getAttribute('data-autoHeight') || false;
        let lazy = +_this.getAttribute('data-lazy') || 0;
        let mousewheel = +_this.getAttribute('data-mousewheel') || 0;

        if (mousewheel) {
            mousewheel = {
                invert: false,
            }
        }

        if (lazy) {
            lazy = {
                loadPrevNext: true,
                loadPrevNextAmount: lazy,
                loadOnTransitionStart: true,
            };
        }

        let autoplay = false;
        let slidesPerGroupSkip = false;

        if (autoplayDelay) {
            autoplay = {
                delay: autoplayDelay,
                disableOnInteraction: false
            }
        }

        if (loop) {
            slidesPerGroupSkip = 1;
        }

        const slidesPerView = _this.getAttribute('data-slides') || 1;
        const slidesPerGroup = +_this.getAttribute('data-slides_group') || 1;

        // responsive sliders count
        const slidesPerView_lg = +_this.getAttribute('data-slides_lg') || slidesPerView;
        const slidesPerView_md = +_this.getAttribute('data-slides_md') || slidesPerView_lg;
        const slidesPerView_sm = +_this.getAttribute('data-slides_sm') || slidesPerView_md;
        const slidesPerView_xs = +_this.getAttribute('data-slides_xs') || slidesPerView_sm;

        // responsive sliders group count
        const slidesPerGroup_lg = +_this.getAttribute('data-slides_group_lg') || slidesPerGroup;
        const slidesPerGroup_md = +_this.getAttribute('data-slides_group_md') || slidesPerGroup_lg;
        const slidesPerGroup_sm = +_this.getAttribute('data-slides_group_sm') || slidesPerGroup_md;
        const slidesPerGroup_xs = +_this.getAttribute('data-slides_group_xs') || slidesPerGroup_sm;

        // responsive spaces
        const spaces_lg = +_this.getAttribute('data-spaces_lg') || spaceBetween;
        const spaces_md = +_this.getAttribute('data-spaces_md') || spaces_lg;
        const spaces_sm = +_this.getAttribute('data-spaces_sm') || spaces_md;
        const spaces_xs = +_this.getAttribute('data-spaces_xs') || spaces_sm;

        const breakpoints = {
            [BREAKPOINTS.zero]: {
                slidesPerView: slidesPerView_xs,
                slidesPerGroup: slidesPerGroup_xs,
                spaceBetween: spaces_xs,
            },
            [BREAKPOINTS.xs]: {
                slidesPerView: slidesPerView_sm,
                slidesPerGroup: slidesPerGroup_sm,
                spaceBetween: spaces_sm,
            },
            [BREAKPOINTS.sm]: {
                slidesPerView: slidesPerView_md,
                slidesPerGroup: slidesPerGroup_md,
                spaceBetween: spaces_md,
            },
            [BREAKPOINTS.md]: {
                slidesPerView: slidesPerView_lg,
                slidesPerGroup: slidesPerGroup_lg,
                spaceBetween: spaces_lg,
            },
            [BREAKPOINTS.lg]: {
                slidesPerView,
                slidesPerGroup,
                spaceBetween,
            },
        };

        /* ----- INIT PARAMS ----- */
        swipers[index] = new Swiper('.' + index, {
            direction,
            initialSlide,
            speed,
            autoplay,
            spaceBetween,
            loop,
            autoHeight,
            lazy,
            effect,
            slidesPerView,
            slideToClickedSlide,
            centeredSlides,
            breakpoints,
            mousewheel,
            simulateTouch: true,
            slidesPerGroup: slidesPerGroup,
            slidesPerGroupSkip: slidesPerGroupSkip,
            loopAdditionalSlides: 4,
            roundLengths: true,
            noSwiping: true,
            updateOnWindowResize: true,
            noSwipingClass: 'swiper-no-swiping',
            watchSlidesVisibility: true,
            slideVisibleClass: 'swiper-slide-visible',
            coverflowEffect: {
                rotate: 30,
                slideShadows: false,
            },
            navigation: {
                nextEl: arrowNext,
                prevEl: arrowPrev,
            },
            pagination: {
                el: '.swiper-pagination-' + index,
                type: paginationType,
                clickable: true,
            },
            on: {
                slideChangeTransitionStart: function (swiper) {
                    $('.swiper-container.' + index).addClass('is-mooving');
                },
                slideChangeTransitionEnd: function (swiper) {
                    $('.swiper-container.' + index).removeClass('is-mooving');
                },
            }
        });
    };

    window.initSwiper = target => {
        if (target) {
            Array.prototype.forEach.call(target, initSwiperElement);
        }
    };

    $(window).on('load ', () => {

        setTimeout(function () {
            $(window).trigger('resize');
        }, 200);

        initSwiper(swipersDOM);
    });

    $WIN.on('elementor/frontend/init', function () {
        let i = false;

        if ((window.location.href.indexOf("elementor-preview") > -1)) {
            elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
                if ($('.swiper-container').length) {
                    initSwiper(swipersDOM);
                    initSwiperElement();
                }
            });
        }
    });

    document.addEventListener("DOMContentLoaded", function () {
        window.scrollTo(window.pageXOffset, window.pageYOffset - 1);
        window.scrollTo(window.pageXOffset, window.pageYOffset + 1);
    });

})(jQuery, window, document);