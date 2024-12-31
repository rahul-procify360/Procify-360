;
(function ($, window, document, undefined) {
	"use strict";

	if($('.aheto-contents--funero-content-accordion .js-accordion-content').length){
		$('.aheto-contents--funero-content-accordion .js-accordion-content').hide();
		$('.aheto-contents--funero-content-accordion .js-accordion-content.js-is-open').show();
	}
	$('.aheto-contents--funero-content-accordion .js-accordion-title').on('click', function (e) {
		e.preventDefault();
		$('.aheto-contents--funero-content-accordion .js-accordion-title').removeClass('is-active');
		$(this).addClass('is-active');
		var num = $(this).attr('data-num');
			$('.aheto-contents--funero-content-accordion .js-accordion-content').removeClass('js-is-open').hide(300);
			$('.aheto-contents--funero-content-accordion .js-accordion-content[data-num="' + num + '"]').addClass('js-is-open').show(300);
	});


	function funero_popup() {
		if ($('.aheto-contents--funero-content-accordion .aheto-contents__gallery-wrap').length) {
			$('.aheto-contents--funero-content-accordion .aheto-contents__gallery-wrap').magnificPopup({
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

	$(window).on('load', function () {
		funero_popup();


	});
})(jQuery, window, document);