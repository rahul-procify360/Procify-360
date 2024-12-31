;(function ($, window, document, undefined) {
	'use strict';

		$(window).on('load resize', function () {
			const singleImg = $('.aheto-single-img');

			singleImg.each(function () {
				const dataWidth = $(this).data('width');

				if ($(window).width() < dataWidth) {
					$(this).fadeOut();
				} else {
					$(this).fadeIn();
				}
			})

		});

})(jQuery, window, document);