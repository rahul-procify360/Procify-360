/*eslint no-undef:0*/


;(function ($, window, document, undefined) {
	"use strict";
	const $isotope = $('.aheto-cpt--karma_construction-grid .js-isotope');
	const isotopes = [];

	function isotope_init() {
		if ($isotope.length) {

			$isotope.each(function ()  {
				let layout = $(this).attr('data-layout') || 'masonry';
				let id = $(this).attr('data-cpt-id');
				isotopes[id] = $(this).isotope({
					percentPosition: true,
					layoutMode: layout,
					masonry: {
						columnWidth: '.aheto-cpt-article--size',
					},
					hiddenStyle: {
						opacity: 0,
					},
					visibleStyle: {
						opacity: 1,
					}
				})
			});

		}
	}

	/* ISOTOPE INIT */
	$(window).on('load', () => {
		isotope_init();
	});

	/* ISOTOPE FILTER */
	$('.aheto-cpt--karma_construction-grid .aheto-cpt-filter__item a').on('click', function (e) {
		e.preventDefault();
		var $element = $('.aheto-cpt--karma_construction-grid .aheto-cpt-article');
		$element.css('opacity', 0);
		isotope_filter($(this));

		setTimeout(function () {
			$element.css('opacity', 1);
		}, 700);
	});

	function isotope_filter($this) {
		let filterValue = $this.attr('data-cpt-filter');
		let id = $this.attr('data-cpt-id');

		$('[data-cpt-id=' + id + ']').removeClass('is-active');

		$this.addClass('is-active');
		isotopes[id].isotope({
			filter: filterValue,
			hiddenStyle: {
				opacity: 0,
			},
			visibleStyle: {
				opacity: 1,
			}
		});
	}

})(jQuery, window, document);
