<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'moovit_features_single_layout1' );

/**
 * Features Single
 */

function moovit_features_single_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Features Single 34', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['s_heading', 't_heading', 'use_heading', 's_description', 's_image', 't_description', 'use_description' ], [ 'moovit_layout1'], $shortcode );

	$shortcode->add_dependecy( 'moovit_link', 'template', 'moovit_layout1' );

	$shortcode->add_params( [
		'moovit_link' => [
			'type'        => 'link',
			'heading'     => esc_html__( 'Link', 'moovit' ),
			'description' => esc_html__( 'Add url to item.', 'moovit' ),
			'placeholder' => __( 'https://your-link.com', 'aheto' ),
			'default'     => [
				'url' => '#',
			],
		],

	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', ['moovit_layout1']]
	]);
}