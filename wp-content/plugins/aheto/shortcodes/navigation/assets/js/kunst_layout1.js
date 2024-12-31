;(function ($, window, document) {

	"use strict";

	//Home page left, dropdown click
	let openSubMenu = () => {
		$('.main-header--kunst__classic .sub-menu').hide();

		if ($('.main-header--kunst__classic .main-menu .menu-item > a').length) {
			$('.main-menu .menu-item > a').on('click', function () {
				if ($(this).parents('.sub-menu').length) {
					$(this).removeClass('active');
				} else {
					if ($(this).hasClass('active')) {
						$(this).removeClass('active').next().next().stop().slideUp();
					} else {
						$('.main-menu .menu-item > a.active').toggleClass('active').next().next('.sub-menu').removeClass('sub-menu-active').stop().slideToggle();
						$(this).addClass('active').next().next().addClass('sub-menu-active').stop().slideDown();
					}
				}
			});
		}

		if ($('.main-header--kunst__classic .sub-menu .menu-item > a').length) {
			$('.sub-menu .menu-item > a').on('click', function () {
				if ($(this).parents('.sub-menu').length) {
					if ($(this).hasClass('active')) {
						$(this).removeClass('active').next().next().stop().slideUp();
					} else {
						$(this).toggleClass('active').next().next().removeClass('sub-menu-active').stop().slideToggle();
					}
				}
			});
		}
	};

	//Custom Scrollbar in header menu
	function kunst_menu_height() {
		const asideMenu = $(".main-header--kunst__classic");
		const mainLineAsideMenu = $(".main-header--kunst__classic .main-header__main-line");
		const menuWrapper = $(".main-header--kunst__classic .menu-home-page-container");
		const menu = $(".main-header--kunst__classic .main-menu");
		let menuHeight;
		let widgetsHeight = 0;
		let logoHeight = 0;
		let ww = 0;

		if ($('.main-header--kunst__classic').length !== 0) {
			$('body').addClass('kunst-aside-menu');
		}
		if ($(window).width() > 1200) {
			ww = $('body.kunst-aside-menu').width() + 1;

			$('body.kunst-aside-menu > .container .vc_row[data-vc-full-width], body.kunst-aside-menu > .container .elementor-section.elementor-section-stretched').css('max-width', ww);
			$('body.kunst-aside-menu > .aheto-footer > .container .vc_row[data-vc-full-width], body.kunst-aside-menu > .aheto-footer > .container .elementor-section.elementor-section-stretched').css('max-width', ww);

			let mainLineAsideMenuPaddT = typeof(mainLineAsideMenu.css('padding-top')) != "undefined" ? mainLineAsideMenu.css('padding-top').replace('px', '') : 0;
			let mainLineAsideMenuPaddB = typeof (mainLineAsideMenu.css('padding-bottom')) != "undefined" ? mainLineAsideMenu.css('padding-bottom').replace('px', '') : 0;

			menuHeight = $(window).height() - mainLineAsideMenuPaddT - mainLineAsideMenuPaddB;

			if (asideMenu.find('.main-header__logo').length) {
				logoHeight = asideMenu.find('.main-header__logo').outerHeight();
				menuHeight = menuHeight - logoHeight;
			}
			if (asideMenu.find('.main-header__widget-box').length) {
				widgetsHeight = asideMenu.find('.main-header__widget-box').outerHeight();
				menuHeight = menuHeight - widgetsHeight;
			}

			menuWrapper.outerHeight(menuHeight);
			menu.css('max-height', menuHeight);
		} else {
			$('body.kunst-aside-menu > .container .vc_row[data-vc-full-width], body.kunst-aside-menu > .container .elementor-section.elementor-section-stretched').css('max-width', 'auto');
			$('body.kunst-aside-menu > .aheto-footer > .container .vc_row[data-vc-full-width], body.kunst-aside-menu > .aheto-footer > .container .elementor-section.elementor-section-stretched ').css('max-width', 'auto');
			menuWrapper.outerHeight('auto');
			menu.css('max-height', 'auto');
		}
	}

	/* ============================ */
	/* MAIN MENU */
	/* ============================ */

	if ($('.aheto-header').length) {
		const $body = $('body');
		let wpAdminBarH = 0;
		const $hamburger = $('.aheto-header .js-toggle-mobile-menu-top');
		let currentScrollPos;

		// Hamburger click
		$hamburger.on('click', function () {
			$('html, body').animate({
				scrollTop: $('.aheto-header .main-header-js').offset().top - wpAdminBarH
			}, 'slow');

			const $this = $(this);

			let menuBox = $this.closest('.main-header').find('.main-header__menu-box');

			$this.toggleClass('is-active');

			if ($this.hasClass('is-active')) {
				$body.addClass('overflow-hidden');

				currentScrollPos = window.pageYOffset;

				$('html, body').css('height', '0px');

				menuBox.slideToggle('fast').css('display', 'flex');
			} else {
				$body.removeClass('overflow-hidden');

				$('html, body').css('height', '');

				$('html, body').animate({scrollTop: currentScrollPos + "px"}, 10);

				setTimeout(() => {
					menuBox.slideToggle('fast');
				}, 700)
			}
		});
	}

	let bodyWidthInElementor = () => {
		let header = document.querySelector('.main-header--kunst__classic');
		let elementorBody = document.querySelector('body.page-template');
		let elementorContainer = document.querySelector('body.page-template .container .elementor-section.elementor-section-stretched');
		let footer = document.querySelector('body.aheto-footer-template');

		if (!header && footer && elementorBody && elementorContainer) {
			elementorBody.style.paddingLeft = '0';
			elementorContainer.style.maxWidth = "100%";
			elementorContainer.style.left = "0";
			footer.style.paddingLeft = '0';
		}
	};

	$(window).on('load', function () {
		openSubMenu();
		kunst_menu_height();
	});


	$(window).on('load resize', function () {
		//openSubMenu();
		// $('.main-header__menu-box').css('pointer-events', 'none');
		var widthCalc = $('.main-header--kunst__classic .main-header__menu').width();
		$('.main-header--kunst__classic .main-header__main-line').css('right', widthCalc - 80 + 'px');
		bodyWidthInElementor();
		kunst_menu_height();
		var x = false;

		if ($('#wpadminbar').length) {

			let getHeightAdminBar = $('#wpadminbar').css('height');

			if ($(window).width() > 767) {
				$('.main-header--kunst__classic').css('margin-top', getHeightAdminBar);
			} else {
				$('.main-header--kunst__classic').css('margin-top', '0');
			}

			$('.main-header--kunst__classic .main-header__widget-box').css('bottom', '80px');
		} else {
			$('.main-header--kunst__classic').css('margin-top', null);
			$('.main-header--kunst__classic .main-header__widget-box').css('bottom', '50px');
		}

		$('.main-header .main-header__menu-btn').on('click', function () {
			if (!x) {
				//Open
				$('.main-header__menu-btn').addClass('main-header__menu-open');
				$('.sub-menu-active, .sub-menu-active > li').show();
				$('.main-header__menu-box').css('pointer-events', 'all');
				$('.main-header__menu-btn-line').hide();
				if ($(window).width() > 1200) {
					// $('.main-menu').css('visibility', 'visible');
				}
				$('.main-header__text-logo-wrap').fadeOut(250);
				$('.main-header__main-line').css('right', '0px');
				x = true;
			} else {
				//Close
				$('.main-header__menu-btn').removeClass('main-header__menu-open');
				$('.sub-menu-active, .sub-menu-active > li').hide();
				$('.main-header__menu-btn-line').show();
				$('.main-header__menu-box').css('pointer-events', 'none');
				$('.main-header__text-logo-wrap').fadeIn(250);
				$('.main-header__main-line').css('right', widthCalc - 80 + 'px');
				x = false;
			}
		});
	});

})(jQuery, window, document);
