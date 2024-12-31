/**
 * Input Map
 * Admin
 * ==============================================
 */
;(function ($, window, document, undefined) {
	"use strict";


	$(document).on('focus', 'input.addresses_address', function (e) {
		var inputMap = $(this)[0];
		var autocomplete = new google.maps.places.Autocomplete(inputMap);
	});


})(jQuery, window, document);
