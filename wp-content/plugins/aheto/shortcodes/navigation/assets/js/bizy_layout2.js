;(function ($, window, document, undefined) {
	"use strict";

	let mobileMenuCheck = 0;

	$( () => {
		mobileMenuCheck = $('.main-header--bizy_simple').attr('data-mobile-menu');
	});

	function bizy_demo_menu() {
		if ($('.main-header--bizy_simple').length) {

			let menuH = $('.main-header--bizy_simple .main-header__main-line').innerHeight();

			if ($('.main-header--bizy_simple .main-header__pages-list').length) {
				$('.main-header--bizy_simple .main-header__pages-list').css({
					'width': '100%',
					'max-height': $(window).innerHeight() - menuH - 50
				});
			}
		}
	}

	$(window).on('load', function () {
		bizy_demo_menu();
	});

	$(window).on('resize orientationchange', function () {
		bizy_demo_menu();
	});

})(jQuery, window, document);
