( function( $ ) {

	// Document Ready
	$( function() {

		var rows = $( '.post-format-row' )
		$( '.post-format' ).on( 'change', function() {
			var input = $( this ),
				selector = '.cmb-row.post-format-' + input.val()

			rows.addClass( 'hidden' )
			$( selector ).removeClass( 'hidden' )
		})

		$( '.post-format:checked' ).trigger( 'change' )
	})

}( jQuery ) )
