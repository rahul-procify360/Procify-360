/**
 * Additional menu on scroll
 * ==============================================
 */

;(function ($, window, document, undefined) {
	"use strict";

	function fixedAdditionalMenuOnScroll() {

		let positionTop = 0;

		if ($('body').hasClass('admin-bar')) {

			let wpAdminBarH = $(window).width() > 782 ? 32 : 46;

			positionTop += wpAdminBarH;
		}

		if ($('.aheto-header.aheto-header--fixed').length) {

			positionTop += $('.aheto-header.aheto-header--fixed').outerHeight();

		}

		const menu = $('.aheto-navbar--outsourceo-additional.fixed-additional .aheto-navbar--inner');

		if (menu.length) {

			const menuWrapper    = menu.parent();
			const menuWrapperTop = menuWrapper.offset().top;

			let positionElement = menu.offset().top;
			let windowTop       = $(window).scrollTop() + positionTop;

			if (windowTop > positionElement) {

				menu.addClass('aheto-navbar--fixed').css('top', positionTop);

			} else if (menuWrapperTop >= positionElement) {

				menu.removeClass('aheto-navbar--fixed');
			}

		}

	}

	$(window).on('scroll load', function () {

		fixedAdditionalMenuOnScroll();

	});


})(jQuery, window, document);

