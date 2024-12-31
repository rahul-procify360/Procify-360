/**
 * CF7 Input Wrap
 * ==============================================
 */

;(function ($, window, document, undefined) {
	"use strict";

	$  ( () => {

		if ($('.widget_aheto__cf--hr-classic-form input[type="submit"]').length) {
			$('.widget_aheto__cf--hr-classic-form input[type="submit"]').each(function () {
				$(this).wrap('<div class="submit-wrap"></div>')
			})
		}
		if ($('.widget_aheto__cf--hr-classic-form textarea').length) {
			$('.widget_aheto__cf--hr-classic-form textarea').each(function () {
				$(this).closest('.wpcf7-form-control-wrap').wrap('<div class="textarea-wrap"></div>')
			})
		}

	});


	function inputFileTrigger() {
		document.querySelector("html").classList.add('js');

		var fileInput = document.querySelector(".widget_aheto__cf--hr-classic-form .input-file") || false,
			button = document.querySelector(".widget_aheto__cf--hr-classic-form .input-file-trigger") || false,
			the_return = document.querySelector(".widget_aheto__cf--hr-classic-form .file-return") || false;

		if (fileInput) {
			fileInput.addEventListener("change", function (event) {
				var fileName = this.value.split('\\').pop();
				the_return.innerHTML = fileName;
			});
		}
		if (button) {
			button.addEventListener("keydown", function (event) {
				if (event.keyCode == 13 || event.keyCode == 32) {
					fileInput.focus();
				}
			});
			button.addEventListener("click", function (event) {
				fileInput.focus();
				return false;
			});

		}

	}

	window.addEventListener('load', function () {
		inputFileTrigger();
	});

})(jQuery, window, document);










