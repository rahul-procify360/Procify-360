;(function ($, window, document, undefined) {
	"use strict";

	function cf_wrap(){
		if($('.aheto-contents--azyn-modern-slider input[type="submit"]').length){

			$('.aheto-contents--azyn-modern-slider input[type="submit"]').each(function () {
				$(this).wrap('<div class="submit-wraper"><div class="submit-wrap"></div></div>')
			})

		}
	}

	$( () => {
		cf_wrap();
	});

	if ( window.elementorFrontend ) {
		cf_wrap();
	}

})(jQuery, window, document);
