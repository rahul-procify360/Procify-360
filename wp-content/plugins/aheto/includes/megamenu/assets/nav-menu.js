( function( $ ) {

	function addItemType( container ) {
		container.prepend( '<span class="aheto-item-type depth-0">Megamenu</span>' );
		container.prepend( '<span class="aheto-item-type depth-1">Column</span>' );
	}

	$( '.item-controls', '.menu-item' ).each( function() {
		addItemType( $( this ) )
	});

	$( document ).on( 'menu-item-added', function( event, html ) {
		addItemType( html.find( '.item-controls' ) )
	});

	function megaItemTree( parent, isChecked ) {
		$( '.menu-item-data-parent-id[value=' + parent + ']' ).each( function() {
			let field = $( this ),
				parent = field.closest( 'li' ),
				parentID = parseInt( parent.find( '.menu-item-data-db-id' ).val() );

			parent.toggleClass( 'megamenu-active', isChecked );
			if ( 0 < parentID ) {
				megaItemTree( parentID, isChecked )
			}
		})
	}

	$( '#post-body' ).on( 'change', '.field-is-megamenu input', function() {
		let field = $( this ),
			isChecked = field.is( ':checked' ),
			parent = field.closest( 'li' ),
			parentID = parent.find( '.menu-item-data-db-id' ).val();

		parent.toggleClass( 'megamenu-active', isChecked );
		megaItemTree( parentID, isChecked )
	});

	$( document ).on( 'menu-removing-item', function( event, el ) {
		el.toggleClass( 'megamenu-active' );
		megaItemTree( el.find( '.menu-item-data-db-id' ).val(), false )
	});

	$( 'input:checked', '.field-is-megamenu' ).trigger( 'change' );

}( jQuery ) );
