(function ($, window, document, undefined) {
		"use strict";
		if ($('.aheto-features--hr-modern-horizontal').length) {


			$(window).on('load', function () {
				const featureTitle = $('.aheto-features--hr-modern-horizontal .aheto-features-block__title');

				setTimeout(function () {
					featureTitle.css({
						'background': '',
						'transition': '0.5s'
					});
				}, 1);


				featureTitle.on('mouseenter ', function () {
					let imgUrl = $(this).attr('data-bg');
					if (imgUrl) {
						$(this).css({
							'background': `url(${imgUrl})`,
							'transition': '0.5s'
						});
					}
				});

				featureTitle.on('mouseleave', function () {
					$(this).css({
						'background': '',
						'transition': '0.5s'
					});
				});

			});
		}
	}
)(jQuery, window, document);
