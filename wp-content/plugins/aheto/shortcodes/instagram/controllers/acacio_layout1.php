<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_instagram_register', 'acacio_instagram_layout1' );


/**
 * Heading
 */
function acacio_instagram_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/instagram/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Instagram 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

    aheto_demos_add_dependency( ['limit', 'size'], ['acacio_layout1' ], $shortcode );
}


