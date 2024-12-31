;(function ($, window, document, undefined) {

	function deva_demo_menu() {
		if ($('.main-header--deva-simple').length) {

			var maxW = $('.main-header--deva-simple .main-header__main-line').outerWidth();
			var menuH = $('.main-header--deva-simple .main-header__main-line').innerHeight();
			var menuInnerH = $('.main-header--deva-simple .menu-home-page-container').innerHeight();
			$('.main-header--deva-simple .menu-item--mega-menu .mega-menu').css('top', (menuH - menuInnerH) / 2 + menuInnerH);

			if ($('.main-header--deva-simple .main-header__pages-list').length) {

				$('.main-header--deva-simple .main-header__pages-list').css({
					'width': maxW,
					'max-height': $(window).innerHeight() - menuH - 50
				});
			}
		}
	}


	function mobile_animation() {
		if ($('.main-header--deva-simple').length) {

			if ($('.main-header--deva-simple .current-menu-item').length && $('.main-header--deva-simple .current-menu-item').closest('.mega-menu__col').length) {
				$('.main-header--deva-simple .current-menu-item').closest('.mega-menu__col').find('.mega-menu__title').addClass('mega-menu__current');
			}

			$('.main-header--deva-simple .dropdown-btn').each(function () {
				$(this).addClass('dropdown-arrow').removeClass('dropdown-btn');
			})

			$('.main-header--deva-simple .dropdown-arrow').off().on('click', function () {

				var mobileMenu = $('.main-header--deva-simple').attr('data-mobile-menu');

				if ($(window).width() < mobileMenu) {

					var submenu = $(this).next().clone();
					var parent = $(this).parent().parent();
					var backBtn = $('.main-header--deva-simple .main-header__menu-box').attr('data-back');

					if ($(submenu).prop("tagName") == "DIV") {
						$(submenu).prepend('<div class="deva-back">' + backBtn + '</div>');
					} else {
						$(submenu).prepend('<li class="deva-back">' + backBtn + '</li>');
					}

					$('.main-header--deva-simple .menu-home-page-container').append(submenu);
					$(submenu).removeClass('mobile-nav-out').removeClass('mobile-sub-nav-out').addClass("mobile-sub-nav-in").show();
					parent.removeClass("mobile-sub-nav-in").removeClass('mobile-nav-in').addClass('mobile-nav-out').delay(200).hide();

					mobile_animation();

					$('.main-header--deva-simple .deva-back').on('click', function () {

						var $this = $(this);
						$this.parent().removeClass('mobile-sub-nav-in').addClass('mobile-sub-nav-out');

						parent.removeClass('mobile-nav-out').removeClass('mobile-sub-nav-out').addClass('mobile-nav-in');

						setTimeout(function () {
							$this.parent().remove();
							parent.css('display', 'block');
						}, 200);

					});
				}
			});

		}
	}

	$(window).on('load', function () {
		setTimeout(mobile_animation, 300);

		deva_demo_menu();
		if ($('.main-header--deva-simple').length) {
			$('body').addClass('aheto-menu--deva-simple');
		}

		$('.aheto-menu--deva-simple .body-overlay').on('click', function () {
			$('.main-header--deva-simple .btn-close').trigger('click');
		});

	});

	$(window).on('resize orientationchange', function () {
		deva_demo_menu();
	});


	$(window).on('load resize orientationchange', function () {
		setTimeout(function () {
			let $megaMenuBlock = $('.submenu-2 .sub-menu.mega-menu');

			if ($megaMenuBlock.length) {

				$megaMenuBlock.each(function () {

					let $megaMenuItem = $(this).closest('.menu-item--mega-menu');

					let $megaMenuItemPosition = $megaMenuItem.offset().left - $('.main-header__main-line').offset().left;

					if (!$(this).find('.mega-menu-arrow').length) {
						$(this).append('<span class="mega-menu-arrow"></span>');
					}
					$(this).find('.mega-menu-arrow').css({
						'left': ($megaMenuItemPosition + 30)
					})
				})
			}
		}, 500);
	})

	$(document).ready(function () {
		setTimeout(function () {
			mobile_animation();
		}, 500);
	})


})(jQuery, window, document);
