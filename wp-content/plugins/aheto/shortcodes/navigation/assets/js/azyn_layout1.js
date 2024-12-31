;(function ($, window, document, undefined) {
	"use strict";

	let mobileMenuCheck = 0;

	$(window).on('load', function () {
		if ($('#wpadminbar').length) {
			$('.main-header--azyn-main .desk-menu__close-wrap').css('margin-top', '30px');
		}
		if ($('.aheto-navbar--azyn-modern').length) {
			$('.main-header--azyn-second .main-header__main-line').css({'padding-top': '0', 'padding-bottom': '0'});
		}
	});


	$( () => {
		mobileMenuCheck = $('.main-header--azyn-main').attr('data-mobile-menu');
		const $hamburger = $('.aheto-header .main-header--azyn-main  .js-toggle-desk-menu');
		let menuBox = $('.main-header--azyn-main.main-header').find('.main-header__desk-menu-wrapper');

		// Hamburger click
		$hamburger.on('click', function () {
			menuBox.addClass('menu-open');
			$('body').addClass('sidebar-open no-scroll');
			$('body').css('margin-left', '-15px');
			$('.aheto-header').css('margin-left', '-9px');
		});

		// Close click
		$('.main-header--azyn-main .desk-menu__close').on('click', function () {
			menuBox.removeClass('menu-open');
			$('body').removeClass('sidebar-open no-scroll');
			$('body').css('margin-left', 'unset');
			$('.aheto-header').css('margin-left', 'unset');
		});

	});

	function azyn_demo_menu() {
		if ($('.main-header--azyn-main').length) {

			let maxW = $('.main-header--azyn-main .main-header__main-line').outerWidth();
			let menuH = $('.main-header--azyn-main .main-header__main-line').innerHeight();

			if ($('.main-header--azyn-main .main-header__pages-list').length) {

				$('.main-header--azyn-main .main-header__pages-list').css({
					'width': maxW,
					'max-height': $(window).innerHeight() - menuH - 50
				});
			}
		}
	}

	$(window).on('load', function () {
		azyn_demo_menu();
	});

	$(window).on('resize orientationchange', function () {
		azyn_demo_menu();
	});

	$(window).on('load resize orientationchange', function () {
		let $megaMenuBlock = $('.main-header--azyn-main .sub-menu.mega-menu');

		if ($megaMenuBlock.length) {

			$megaMenuBlock.each(function () {

				let $megaMenuItem = $(this).closest('.menu-item--mega-menu');

				let $megaMenuItemPosition = $megaMenuItem.offset().left - ($(window).width() - $(this).width()) / 2;

				if (!$(this).find('.mega-menu-arrow').length) {
					$(this).append('<span class="mega-menu-arrow"></span>');
				}

				$(this).find('.mega-menu-arrow').css({
					'left': ($megaMenuItemPosition + 30)
				})
			})
		}
	})

})(jQuery, window, document);
