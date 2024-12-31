<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_features-single_register', 'outsourceo_features_single_layout4' );

/**
 * Features Single Shortcode
 */

function outsourceo_features_single_layout4( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'outsourceo_layout4', [
		'title' => esc_html__( 'Features Single 43', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout4.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_link_url', 'template', [ 'outsourceo_layout4' ] );
	$shortcode->add_dependecy( 'outsourceo_link_text', 'template', [ 'outsourceo_layout4' ] );

	aheto_demos_add_dependency( ['s_image', 's_heading', 'use_heading', 't_heading', 's_description', 'use_description', 't_description'], [ 'outsourceo_layout4' ], $shortcode );

	$shortcode->add_params( [
		'outsourceo_link_text' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link Text', 'outsourceo' ),
			'default' => 'Click Me'
		],
		'outsourceo_link_url'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link URL', 'outsourceo' ),
			'default' => '#'
		]
	] );
}