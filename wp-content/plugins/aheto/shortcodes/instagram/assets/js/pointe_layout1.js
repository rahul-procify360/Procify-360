;(function ($, window, document) {
	"use strict";
	const instagram = $('.pointe-instagram');

	function getParamsInstagram() {
		if (instagram.length) {
			instagram.each(function () {
				const max   = +$(this).attr('data-max') || 6;
				const token = $(this).attr('data-token');
				const size  = $(this).attr('data-size');

				$.fn.spectragram.accessData = {
					accessToken: token
				};
				$(this).spectragram('getUserFeed', {
					size: size,
					max: max,
					accessToken: token
				});
			});
		}
	}

	$(window).on('load', function () {
		getParamsInstagram();
	});

})(jQuery, window, document);
