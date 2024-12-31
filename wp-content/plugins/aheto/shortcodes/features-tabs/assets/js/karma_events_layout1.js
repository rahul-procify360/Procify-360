/*eslint no-undef:0*/


;(function ($, window, document, undefined) {
	"use strict";

	const $isotope = $('.aheto-tabs--karma_events-isotope .aheto-tabs__content');
	if (window.elementorFrontend) {
		isotopeInit();
	}

	$( () => {
		isotopeInit();
		initialFiltering();

		$('.aheto-tabs--karma_events-isotope .aheto-tabs__list-item a')
			.on('click', function () {
				$('.aheto-tabs--karma_events-isotope .aheto-tabs__list-item a')
					.removeClass('active');
				$(this)
					.addClass('active');
				var filterValue = $(this).attr('data-pricing-filter');
				$isotope.isotope({
					filter: filterValue
				});
			});
	});

	function isotopeInit() {
		if ($isotope.length) {
			$isotope.each(function () {
				$(this).isotope({
					itemSelector: '.js-isotope-box',
					layoutMode: 'masonry',
					percentPosition: true,
					masonry: {
						gutter: 15
					}
				})
			});

		}
	}

	function initialFiltering() {
		let $firstFilterValue = $('.aheto-tabs--karma_events-isotope [data-pricing-filter]').first().attr('data-pricing-filter');

		$isotope.isotope({
			filter:  $firstFilterValue
		});
	}


})(jQuery, window, document);
