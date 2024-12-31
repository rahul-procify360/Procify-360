<?php


function cf7_views_lite_create_attachment( $filename ) {
	// Check the type of file. We'll use this as the 'post_mime_type'.
	$filetype = wp_check_filetype( basename( $filename ), null );

	// Get the path to the upload directory.
	$wp_upload_dir  = wp_upload_dir();
	$attachFileLink = $wp_upload_dir['url'] . '/' . basename( $filename );
	$attachFileName = $wp_upload_dir['path'] . '/' . basename( $filename );
	$attachFileName = apply_filters( 'cf7_views_create_attachment_file_name', $attachFileName );
	copy( $filename, $attachFileName );
	// Prepare an array of post data for the attachment.
	$attachment = array(
		'guid'           => $attachFileName,
		'post_mime_type' => $filetype['type'],
		'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
		'post_content'   => '',
		'post_status'    => 'inherit',
	);
	// Notify subscribers with attachment data
	$attachment = apply_filters( 'cf7_views_before_insert_attachment', $attachment );
	// Insert the attachment.
	$attach_id = wp_insert_attachment( $attachment, $attachFileName );

	do_action( 'cf7_views_create_attachment_id_generated', $attach_id );

	$attach_data = array(
		'id'   => $attach_id,
		'path' => $attachFileLink,
	);
	return $attach_data;
}

function cf7_views_lite_save_attachment( $result ) {
	$submission = WPCF7_Submission::get_instance();

	if ( $submission ) {
		$uploaded_files = $submission->uploaded_files();
		if ( $uploaded_files ) {

			foreach ( $uploaded_files as $fieldName => $filepath ) {
				$data = array();
				if ( is_array( $filepath ) ) {
					foreach ( $filepath as $key => $value ) {
						$data[] = cf7_views_lite_create_attachment( $value );
					}
				} else {
					$data = cf7_views_lite_create_attachment( $filepath );
				}
				//error_log( '_cf7_attachment_' . $fieldName );
				update_post_meta( $result['flamingo_inbound_id'], '_cf7_attachment_' . $fieldName, $data );

				// error_log( print_r( $data, true ) );
			}
		}
	}
}
// intercept contact form 7 before email send
add_action( 'wpcf7_after_flamingo', 'cf7_views_lite_save_attachment' );
