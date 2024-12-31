; (function ($, window, document, undefined) {
    "use strict";

    $( ".aheto-cpt--snapster-slider-thumb .js-thumbs-switcher" ).on('click', function(){

        const parent = $(this).closest('.aheto-cpt--snapster-slider-thumb');

        parent.find( ".swiper-bottom" ).toggleClass("thumbs-hide");
        parent.find( ".aheto-cpt--slider-content" ).toggleClass("content-slide");

    });

    function snapster_cpt_height(){

        if($('.aheto-cpt--snapster-slider-thumb .snapster-full-min-height-js').length){

            const header = $('.aheto-header:not(.aheto-header--absolute):not(.aheto-header--fixed)');
            let adminBarH = $('body.admin-bar').length ? 32 : 0;
            let headerH = header.length ? header.outerHeight() : 0;

            $('.aheto-cpt--snapster-slider-thumb .snapster-full-min-height-js').css('min-height', $(window).innerHeight() - headerH - adminBarH );

        }

		if($('.aheto-cpt--snapster-slider-thumb .swiper-bottom .swiper-container').length){
			$('.aheto-cpt--snapster-slider-thumb .swiper-bottom .swiper-container').each(function (){
				let slides = $(this).attr('data-slides') || 1;
				let slides_lg = +$(this).attr('data-slides_lg') || slides;
				let slides_md = +$(this).attr('data-slides_md') || slides_lg;
				let slides_sm = +$(this).attr('data-slides_sm') || slides_md;
				let slides_xs = +$(this).attr('data-slides_xs') || slides_sm;

				$(this).closest('.aheto-cpt--snapster-slider-thumb').css({
					'--count-sl': slides,
					'--count-sl_lg': slides_lg,
					'--count-sl_md': slides_md,
					'--count-sl_sm': slides_sm,
					'--count-sl_xs': slides_xs
				});

			});
		}
    }

    $(window).on('load resize orientationchange', function () {

        snapster_cpt_height();

    });

    if ( window.elementorFrontend ) {
        snapster_cpt_height();
    }


})(jQuery, window, document);
