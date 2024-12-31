<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'kunst_custom_post_types_layout7' );

/**
 * Custom post type Shortcode
 */

function kunst_custom_post_types_layout7( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'kunst_layout7', [
		'title' => esc_html__( 'Kunst Grid', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout7.jpg',
	]);

	aheto_demos_add_dependency( [ 'skin', 't_heading', 'use_heading', 't_term', 'use_term' ], [ 'kunst_layout7' ], $shortcode );

}
