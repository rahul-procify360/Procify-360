; (function ($, window, document, undefined) {
	"use strict";
	function sterling_popup() {
		if ($('.aheto-sterling-gallery-img').length)  {
			$('.aheto-sterling-gallery-img').magnificPopup({
				delegate: 'figure',
				type: 'image',
				gallery: {
					enabled: true,
					navigateByImgClick: true,
					preload: [0, 1]
				}
			});
		}
	}

	function showGallery() {
		let parent = $('.grid-item').closest('.aheto-sterling-gallery-img');

		if (parent.find('.hide-item').length >= 6) {
			parent.find('.hide-item').slice(0, 6).removeClass('hide-item');
		} else {
			parent.find('.hide-item').removeClass('hide-item');
		}
	}

	showGallery();

	$(window).on('load', function () {
		sterling_popup();

		let checkItem = $('.grid-item').closest('.aheto-sterling-gallery-img');

		checkItem.find('.hide-item').length == 0 ? $('.aheto-sterling-gallery-button').hide() : $('.aheto-sterling-gallery-button').show();
	});

})(jQuery, window, document);