( function ( $ ) {
	$( function () {
		// Open Views Submenu

		// wp-has-current-submenu wp-menu-open

		// Create new popup
		$( document ).on( 'click', ' .post-type-cf7-views a.add_new_cf7_view', function ( e ) {
			e.preventDefault();
			var cf7_forms = JSON.parse( view_forms );
			var form_dropdown = '<select id="view_form_id">';
			form_dropdown += '<option value=""> Select Form</option>';
			Object.keys( cf7_forms ).forEach( ( form_id ) => {
				// console.log(form);
				form_dropdown += '<option value="' + form_id + '">' + cf7_forms[ form_id ] + '</option>';
			} );

			form_dropdown += '</select>';

			Swal.fire( {
				title: 'Create a new View',
				html: '<div class="create_view_popup"><input id="view_title" placeholder="Add New View Title...">' + form_dropdown + '</div>',
				showCancelButton: true,
				confirmButtonText: 'Create',
				showLoaderOnConfirm: true,
				preConfirm: () => {
					var title = document.getElementById( 'view_title' ).value;
					var form_id = document.getElementById( 'view_form_id' ).value;

					if ( form_id == '' ) {
						alert( 'Please select form.' );
						return false;
					}

					var data = {
						action: 'cf7_views_create_view',
						form_id: form_id,
						title: title,
						create_nonce: cf7_views_admin.create_nonce,
					};
					return $.post( ajaxurl, data, function ( response ) {
						// var res = JSON.parse(response);
						// console.log(res.view_id);
						// return res.view_id;
					} );
				},
				allowOutsideClick: () => !Swal.isLoading(),
			} ).then( ( result ) => {
				if ( result.isConfirmed ) {
					var res = JSON.parse( result.value );
					window.location = cf7_views_admin.admin_url + 'admin.php?page=cf7-views&view_id=' + res.view_id;
				}
			} );
		} );
	} );
} )( jQuery );
