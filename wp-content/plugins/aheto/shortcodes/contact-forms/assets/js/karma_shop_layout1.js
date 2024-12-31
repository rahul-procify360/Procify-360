;(function ($, window, document, undefined) {
	"use strict";

	if ( $('.aheto__cf--line-karma_shop input[type="submit"]').length ) {
		$('.aheto__cf--line-karma_shop input[type="submit"]').each(function () {
			$(this).wrap('<div class="submit-wrap ion-android-send"></div>');
		})
	}


})(jQuery, window, document);