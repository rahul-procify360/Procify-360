;(function ($, window, document, undefined) {
	"use strict";

		$(window).on('load', function () {
			const $isotope = $('.aheto-cpt--hr-metro ');

			/* ISOTOPE INIT */

			if ($isotope.length) {
				$isotope.each(function () {
					$(this).isotope({
						itemSelector: '.aheto-cpt-article--hryzantema_skin-2',
						percentPosition: true,
						layoutMode: 'masonry',
						masonry: {
							columnWidth: '.aheto-cpt--hr-metro-sizer',
						}
					})
				});
			}
		});

})(jQuery, window, document);