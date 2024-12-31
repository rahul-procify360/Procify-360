( function( $ ) {

	// Document Ready
	$( function() {
		$( '.aheto-option-content' ).on( 'click', '.install-now', function( event ) {;
			var $button = $( event.target )
			event.preventDefault()

			if ( $button.hasClass( 'updating-message' ) || $button.hasClass( 'button-disabled' ) ) {
				return
			}

			if ( wp.updates.shouldRequestFilesystemCredentials && ! wp.updates.ajaxLocked ) {
				wp.updates.requestFilesystemCredentials( event )

				$document.on( 'credential-modal-cancel', function() {
					var $message = $( '.install-now.updating-message' )

					$message
						.removeClass( 'updating-message' )
						.text( wp.updates.l10n.installNow )

					wp.a11y.speak( wp.updates.l10n.updateCancel, 'polite' )
				})
			}

			wp.updates.installPlugin({
				slug: $button.data( 'slug' )
			})
		});


        $( '.aheto-option-content' ).on( 'click', 'input[name="plugin-select"]', function( ) {
            $('.aheto-setup-actions.step input[name="save_step"]').removeClass('default');
        });

		$( document ).on( 'wp-plugin-install-success', function( response ) {
			// window.location.reload()
		});


		let getTitle = document.querySelector('.aheto-option-page-nav .aheto-option-nav-wrap .nav-active') ? document.querySelector('.aheto-option-nav-wrap .nav-active').getAttribute('title') : '';
		document.querySelector('.options-page-title') ? document.querySelector('.options-page-title').textContent = getTitle : '' ;

	})


}( jQuery ) )
