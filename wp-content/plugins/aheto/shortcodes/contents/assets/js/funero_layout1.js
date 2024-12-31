;
(function ($, window, document, undefined) {
	"use strict";

	function sliderNumber() {
		const $parent = $('.aheto-contents--funero-creative-slider .aheto-contents-swiper-left');

		var $realIndexStr = $('.aheto-contents--funero-creative-slider .aheto-contents-swiper-left .swiper-slide-thumb-active').attr('data-swiper-slide-index');
		const realIndex = parseInt($realIndexStr) + 1;
		const total = $parent.find('.swiper-slide:not(.swiper-slide-duplicate)').length;

		let nextIndex = realIndex + 1;
		nextIndex = nextIndex > total ? nextIndex - total : nextIndex;

		let prevIndex = realIndex - 1;
		prevIndex = prevIndex <= 0 ? total - prevIndex : prevIndex;

		$parent.find('.swiper-button-prev').html(prevIndex);
		$parent.find('.swiper-button-next').html(nextIndex);
	}

		$(window).on('load resize orientationchange', function () {
			sliderNumber();
		});

})(jQuery, window, document);