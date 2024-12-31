/* global ClipboardJS */
( function( $ ) {

	'use strict';

	// Document Ready
	$( function() {


		var adminDashboard = {

			init: function() {
				this.systemInfo()
			},

			systemInfo: function() {

				if ( 'undefined' === typeof ClipboardJS ) {
					return
				}

				// Debug Report
				$( '.aheto-option-header' ).on( 'click', '.get-debug-report', function() {

					$( '#debug-report' ).slideToggle();
					$( '#debug-report textarea' ).focus().select();
					return false
				});


				var clipboard = new ClipboardJS( '#copy-for-support' );
				clipboard.on( 'success', function() {
					$( '#debug-report' ).slideToggle()
				})
			}
		};

		adminDashboard.init();
	})

}( jQuery ) );
