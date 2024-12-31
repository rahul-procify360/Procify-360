/*eslint no-undef:0*/


;(function ($, window, document, undefined) {
	"use strict";
	const $isotope = $('.js-isotope');
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
	$('.aheto-cpt-filter__item a').on('click', function (e) {
		e.preventDefault();

		isotope_filter($(this));
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

	$('.js-inRow').on('click', function (e) {
		e.preventDefault();
		var $element = $('.aheto-cpt-article');
		$element.css('opacity', 0);
		$('.js-inRow').removeClass('is-active');
		$(this).addClass('is-active');
		var $count = $(this).attr('data-count');
		setTimeout(function () {
			$('.aheto-cpt-article--size').css('width', 'calc(100% / ' + $count + ')');
			$element.css('width', 'calc(100% / ' + $count + ')');
		}, 400);
		setTimeout(function () {
			isotope_filter($('.is-active'));
		}, 400);
		setTimeout(function () {
			$element.css('opacity', 1);
		}, 500);

	})

})(jQuery, window, document);
