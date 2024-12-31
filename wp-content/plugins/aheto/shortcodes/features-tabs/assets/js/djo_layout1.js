;(function ($, window, document, undefined) {
	"use strict";

	/**
	 * Tabs
	 *
	 * @param $target $('.class') - tab item
	 * @param $selector1 '.class' - tabs main wrapper
	 * @param $selector2 '.class' - tabs content item
	 */

	function tabChange($target, $selector1, $selector2) {
		$target.on('click', function (e) {
			e.preventDefault();

			const indexEl = $(this).parent().index();

			$(this)
				.parent()
				.addClass('active')
				.siblings()
				.removeClass('active')
				.closest($selector1)
				.find($selector2)
				.removeClass('active')
				.eq(indexEl)
				.addClass('active');
		});
	}

	if ($('.aheto-features-tabs--modern').length) {
		tabChange($('.aheto-features-tabs--modern .js-djo-tab-list'), '.aheto-features-tabs--modern .js-djo-tab', '.aheto-features-tabs--modern .js-djo-tab-box');
	}
	/**
	 * Hide swiper navigation
	 */
	if ($('.aheto-features-tabs--modern').length) {
		$('.aheto-features-tabs--modern .js-vertical-swiper').each(function () {
			const $this = $(this);

			if ($this.find('.js-slide').not('.disabled').length <= 3) {

				$(this)
					.find('.js-nav')
					.hide();
			}
		});
	}
})(jQuery, window, document);