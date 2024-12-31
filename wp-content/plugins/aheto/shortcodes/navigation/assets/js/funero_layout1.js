;(function ($, window, document, undefined) {
	"use strict";

	$(window).on('load', function () {
		if ($('#wpadminbar').length) {
			$('.main-header--funero-main .desk-menu__close-wrap').css('margin-top', '30px');
		}
		if ($('.aheto-navbar--funero-modern').length) {
			$('.main-header--funero-second .main-header__main-line').css({'padding-top': '0', 'padding-bottom': '0'});
		}
	});


	$( () => {
		const $hamburger = $('.aheto-header .main-header--funero-main  .js-toggle-desk-menu');
		let menuBox = $('.main-header--funero-main.main-header').find('.main-header__desk-menu-wrapper');

		// Hamburger click
		$hamburger.on('click', function () {
			menuBox.addClass('menu-open');
			$('body').addClass('sidebar-open no-scroll');
			$('body').css('margin-left', '-15px');
			$('.aheto-header').css('margin-left', '-9px');
		});

		// Close click
		$('.main-header--funero-main .desk-menu__close').on('click', function () {
			menuBox.removeClass('menu-open');
			$('body').removeClass('sidebar-open no-scroll');
			$('body').css('margin-left', 'unset');
			$('.aheto-header').css('margin-left', 'unset');
		});

	});

})(jQuery, window, document);