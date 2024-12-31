; (function ($, window, document, undefined) {
	"use strict";
	function soapy_popup() {
		if ($('.aheto-soapy-gallery-img').length)  {
			$('.aheto-soapy-gallery-img').magnificPopup({
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
		let parent = $('.grid-item').closest('.aheto-soapy-gallery-img');

		if (parent.find('.hide-item').length >= 6) {
			parent.find('.hide-item').slice(0, 6).removeClass('hide-item');
		} else {
			parent.find('.hide-item').removeClass('hide-item');
		}
	}

	showGallery();

	$(window).on('load', function () {
		soapy_popup();

		let checkItem = $('.grid-item').closest('.aheto-soapy-gallery-img');

		checkItem.find('.hide-item').length == 0 ? $('.aheto-soapy-gallery-button').hide() : $('.aheto-soapy-gallery-button').show();
	});

})(jQuery, window, document);