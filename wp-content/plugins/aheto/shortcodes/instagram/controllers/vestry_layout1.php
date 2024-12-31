<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_instagram_register', 'vestry_instagram_layout1' );


/**
 * Heading
 */
function vestry_instagram_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/instagram/previews/';

	$shortcode->add_layout( 'vestry_layout1', [
		'title' => esc_html__( 'Instagram 6', 'acacio' ),
		'image' => $preview_dir . 'funero_layout1.jpg',
	] );

    aheto_demos_add_dependency( ['limit', 'size'], ['vestry_layout1' ], $shortcode );

}