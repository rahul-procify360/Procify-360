;(function ($, window, document, undefined) {
	"use strict";

	$(window).on('load resize', function () {
		if ($('.aheto-single-img--hr ').length) {
			const dataWidth = $('.aheto-single-img--hr .aheto-single-img').data('width');
			if ($(window).width() < dataWidth) {
				$('.aheto-single-img--hr .aheto-single-img').fadeOut();
			} else {
				$('.aheto-single-img--hr .aheto-single-img').fadeIn();
			}
		}
	});

})(jQuery, window, document);