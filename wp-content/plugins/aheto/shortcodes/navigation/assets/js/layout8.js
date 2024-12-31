;(function ($, window, document, undefined) {
	"use strict";

	let mobileMenuCheck = 0;

	$( () => {
		mobileMenuCheck = $('.main-header--classic-2').attr('data-mobile-menu');
	});

	function aheto_demo_menu() {
		if ($('.main-header--classic-2').length) {

			let menuH = $('.main-header--classic-2 .main-header__main-line').innerHeight();

			if ($('.main-header--classic-2 .main-header__pages-list').length) {
				$('.main-header--classic-2 .main-header__pages-list').css({
					'width': '100%',
					'max-height': $(window).innerHeight() - menuH - 50
				});
			}
		}
	}

	$(window).on('load', function () {
		aheto_demo_menu();
	});

	$(window).on('resize orientationchange', function () {
		aheto_demo_menu();
	});

	$(window).on('load resize orientationchange', function () {
		let $megaMenuBlock = $('.main-header--classic-2 .sub-menu.mega-menu');

		if ($megaMenuBlock.length) {
			$megaMenuBlock.each(function () {

				let $megaMenuItem = $(this).closest('.menu-item--mega-menu');
				let $megaMenuItemPosition = $megaMenuItem.position().left;

				if (!$(this).find('.mega-menu-arrow').length) {
					$(this).append('<span class="mega-menu-arrow"></span>');
				}

				$(this).find('.mega-menu-arrow').css({
					'left': ($megaMenuItemPosition + 45)
				})
			})
		}
	})

})(jQuery, window, document);
