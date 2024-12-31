<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'outsourceo_contents_layout3' );

/**
 * Contents Shortcode
 */

function outsourceo_contents_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'outsourceo_layout3', [
		'title' => esc_html__( 'Content 27', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout3.jpg',
	] );

	aheto_demos_add_dependency( ['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], [ 'outsourceo_layout3' ], $shortcode );
}