;(function ($, window, document, undefined) {
	"use strict";

	function leadZero(n) {
		return (n < 10 ? '0' : '') + n;
	}

	$('.aheto-contents--azyn-interactive-links').each(function () {
		let el_area = $(this),
			items = el_area.find('.aheto-contents__slide'),
			images_area = el_area.find('.aheto-contents--owl-images'),
			flag = true;

		items.each(function () {
			$(this).attr('data-eq', $(this).index());
			images_area.append('<div class="img-item" style="background-image: url(' + $(this).attr('data-image') + ')"><div class="num">' + leadZero($(this).index() + 1) + '</div></div>');
		});

		el_area.find('.aheto-contents--owl').on('initialized.owl.carousel translated.owl.carousel', function (e) {
			let eq = $(this).find('.center .aheto-contents__slide').attr('data-eq');
			images_area.find('.img-item').eq(eq).addClass('active').siblings().removeClass('active');
		});

		el_area.find('.aheto-contents--owl').owlCarousel({
			loop: true,
			items: 1,
			center: true,
			autoWidth: true,
			nav: false,
			dots: false,
			autoplay: false,
			autoplayHoverPause: true,
			navText: false,
			slideBy: 1,
		});

		el_area.on('mousewheel wheel', function (e) {
			if (!flag) return false;
			flag = false;

			let d = e.originalEvent.deltaY;
			if (e.originalEvent.deltaY) {
				d = e.originalEvent.deltaY;
			} else {
				d = e.deltaY;
			}

			if (d > 0) {
				el_area.find('.aheto-contents--owl').trigger('next.owl');
			} else {
				el_area.find('.aheto-contents--owl').trigger('prev.owl');
			}

			setTimeout(function () {
				flag = true
			}, 600)
			e.preventDefault();
		});
	});

})(jQuery, window, document);
