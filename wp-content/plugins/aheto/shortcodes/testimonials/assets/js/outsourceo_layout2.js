;(function ($, window, document, undefined) {

	$(window).on('load resize orientationchange', () => {

		if ($(window).width() > 1200 ) {

			let $blockOutCont = ($(window).outerWidth(true) - $('.elementor-section.elementor-section-boxed>.elementor-container').width() - 15) / 2;

			$('.aheto-tm-wrapper--oursourceo-creative .swiper').css({
				'left': $blockOutCont
			});

		}
	})

})(jQuery, window, document);