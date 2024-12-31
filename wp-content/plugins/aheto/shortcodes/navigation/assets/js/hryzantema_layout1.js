;(function ($, window, document, undefined) {
	"use strict";

	let prevScrollpos = window.pageYOffset;

	function hideMenuOnScroll() {
		if ($('.main-header--simple-button').length) {
			const mobileMenu = +$('.main-header--simple-button').data('mobile-menu');
			let currentScrollPos = window.pageYOffset;
			let headerHeight = $('.main-header--simple-button .hr-header-2-top').outerHeight();

			if ($(window).width() > mobileMenu) {
				if (prevScrollpos > currentScrollPos) {

					$('.main-header--simple-button .hr-header-2-top').css({
						'margin-top': '0px',
						'transition': '0.5s'
					});

					$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').removeClass('dark-scroll');

				} else {
					$('.main-header--simple-button .hr-header-2-top').css({
						'margin-top': `-${headerHeight}px`,
						'transition': '0.5s'
					});
					$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').addClass('dark-scroll');
				}

				if (currentScrollPos == 0 || currentScrollPos < 5) {
					$('.main-header--simple-button .hr-header-2-top').css({
						'margin-top': '0px',
						'transition': '0.5s'
					});
					$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').removeClass('dark-scroll');
					if ($('.main-header--simple-button .main-header__hamburger').hasClass('is-active')) {
						$('.hr-header-2-top').css({
							'margin-top': `-${headerHeight}px`,
							'transition': '0.5s'
						});
					}
				}

				prevScrollpos = currentScrollPos;

			} else {
				$('.main-header--simple-button .hr-header-2-top').parents('.aheto-header--fixed.header-scroll').removeClass('dark-scroll');
			}

			const scrollY = document.documentElement.style.getPropertyValue('--scroll-y');

			let oldScroll = null;

			$('.main-header--simple-button .js-toggle-mobile-menu').on('click', function (e) {
				e.preventDefault();

				oldScroll = scrollY;

				$('html, body').addClass('no-scroll');

			});

			$('.main-header--simple-button .btn-close').on('click', function (e) {
				e.preventDefault();

				$('html, body').removeClass('no-scroll');

				window.scrollTo({
					top: oldScroll,
					behavior: 'smooth'
				});
			});
		}
	}


	window.addEventListener('scroll', () => {
		document.documentElement.style.setProperty('--scroll-y', `${window.scrollY}`);
	});

	$(window).on('load scroll', function () {
		hideMenuOnScroll();
	});

})(jQuery, window, document);