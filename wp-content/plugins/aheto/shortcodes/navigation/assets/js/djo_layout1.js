;
(function ($, window, document, undefined) {
	"use strict";


	if ($('.main-header--djo-layout1').length) {

		const $WIN = $(window),
			$mainHeader = $('.main-header-js'),
			$topMenu = $('.main-header-js ul'),
			$menuItems = $topMenu.find("a"),
			topMenuHeight = $('.aheto-header').outerHeight() + 50,
			$toggleMenu = $('.js-toggle-menu'),
			$headerWrap = $('.aheto-header'),
			$body = document.querySelector('body'),
			$menuBox = $headerWrap.find('.main-header__menu-box'),
			scrollItems = $menuItems.length && $menuItems
				.map(function () {
					if ($(this).attr('href').indexOf("#") >= 0) {
						const item = $($(this).attr("href"));
						if (item.length) {
							return item;
						}
					}
				});

		let lastId,
			$winHeight = $WIN.height(),
			scrollPosition = 0;

		const scrollControl = {
			enable() {
				scrollPosition = window.pageYOffset;
				$body.style.overflow = 'hidden';
				$body.style.position = 'fixed';
				$body.style.top = `-${scrollPosition}px`;
				$body.style.width = '100%';
			},
			disable() {
				$body.style.removeProperty('overflow');
				$body.style.removeProperty('position');
				$body.style.removeProperty('top');
				$body.style.removeProperty('width');
				window.scrollTo(0, scrollPosition);
			},
		};

		/**
		 * Check if home page
		 */

		const isHome = $('body').hasClass('home') || $('.js-home').hasClass('home') ? true : false;

		/**
		 * Set up custon namespace to prevent Elementor default ScrollToId
		 * Custom scroll to target section
		 */

		$menuItems.on('click.djoNav', function (e) {
			const href = $(this).get(0).getAttribute('href');
			const mobileMenu = +$(this).closest('.main-header-js').data('mobile-menu');

			if (href.indexOf('#') >= 0) {
				e.preventDefault();
			}

			if (!isHome) {
				const targetID = $(this).data('id') ? $(this).data('id') : '';
				//save in localstorage Id of target section
				localStorage.setItem('blockID', targetID);
			}

			$menuBox.removeClass('open');
			$('body').removeClass('sidebar-open');
			if ($(window).width() <= (mobileMenu + 1)) {
				scrollControl.disable();
			}

			scrollTo(href);
		});

		/**
		 * Scrool to Id function
		 */

		function scrollTo(id) {
			//check if the url is realy ID
			if (id.indexOf("#") >= 0) {
				const offsetTop = $(id).length ? $(id).offset().top - topMenuHeight + 1 : 0;
				if (offsetTop) {
					$('html, body').stop().animate({
						scrollTop: offsetTop
					}, 350);
				}
			}
		}

		/**
		 * Prevent other events on main nav items(if namespace != to created  before)
		 */

		$WIN.on("load", () => {
			//get target section ID
			if (localStorage.getItem('blockID')) {
				const targetID = localStorage.getItem('blockID');
				scrollTo(targetID);
				localStorage.removeItem('blockID');
			}

			setTimeout(() => {
				const $doc = $(document),
					$events = $menuItems.length ? $._data($doc[0], "events") : null;
				if ($events) {
					for (let i = $events.click.length - 1; i >= 0; i--) {
						const handler = $events.click[i];
						if (handler && handler.namespace != "djoNav" && handler.selector === 'a[href*="#"]') {
							$doc.off("click", handler.handler);
						}
					}
				}
			}, 300);
		});

		/**
		 * Toogle menu on mobile
		 */

		if ($headerWrap.length) {

			$toggleMenu.on('click', function () {
				scrollControl.enable();
				$menuBox.addClass('open');
				$('body').addClass('sidebar-open');
			});
		}

		document.addEventListener('touchstart', (event) => {
			if (event.target && event.target.className === 'body-overlay') {
				scrollControl.disable();
				$body.classList.remove('sidebar-open');
				$menuBox.removeClass('open');
			}
		});

		/**
		 * Close mobile menu
		 */

		$(document).on('click', '.btn-close', function () {
			scrollControl.disable();
			$menuBox.removeClass('open');
			$('body').removeClass('sidebar-open');
		})

		/**
		 * Highlight active menu on scroll
		 */

		$WIN.on('scroll', function () {
			const fromTop = $(this).scrollTop() + topMenuHeight;

			let cur = scrollItems.map(function () {
				if ($(this).offset().top < fromTop)
					return this;
			});

			cur = cur[cur.length - 1];

			const id = cur && cur.length ? cur[0].id : "";

			if (id && lastId !== id) {
				lastId = id;
				$menuItems
					.parent().removeClass("active")
					.end()
					.filter("[href=\\#" + id + "]")
					.parent()
					.addClass("active");
			} else if (!id) {
				$menuItems
					.parent().removeClass("active");
			}
		});

		/**
		 * Change links for inner pages
		 */

		if (!isHome) {
			const homeUrl = $('.main-header--djo-layout1  .main-header__logo > a').attr('href');
			const linksArr = $mainHeader.find('.menu-item > a');

			linksArr.each(function () {
				const thisUrl = $(this).attr('href');

				//check if this link to ID
				if (thisUrl.indexOf("#") >= 0) {
					const newUrl = homeUrl;

					//save target id in data-atrribute
					$(this).attr('data-id', thisUrl);
					//set url to home page instead of ID
					$(this).attr('href', newUrl);
				}
			});

		}
	}
})(jQuery, window, document);
