<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_features-single_register', 'outsourceo_features_single_layout2' );

/**
 * Features Single Shortcode
 */

function outsourceo_features_single_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Features Single 41', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );


	$shortcode->add_dependecy( 'outsourceo_link_url', 'template', [ 'outsourceo_layout2' ] );
	$shortcode->add_dependecy( 'outsourceo_logo_image', 'template', ['outsourceo_layout2'] );
	$shortcode->add_dependecy( 'outsourceo_overlay', 'template', ['outsourceo_layout2'] );
	$shortcode->add_dependecy( 'outsourceo_overlay_color', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_overlay_color', 'outsourceo_overlay', 'true' );

	aheto_demos_add_dependency( ['s_image', 's_heading', 's_description'], ['outsourceo_layout2' ], $shortcode );

	$shortcode->add_params( [
		'outsourceo_link_url'      => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link URL', 'outsourceo' ),
			'default' => '#'
		],
		'outsourceo_overlay'       => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable overlay for background image?', 'outsourceo' ),
			'grid'    => 12,
		],
		'outsourceo_overlay_color' => [
			'type'    => 'colorpicker',
			'heading' => esc_html__( 'Overlay Color', 'outsourceo' ),
			'grid'    => 12,
			'default' => ''
		],
		'outsourceo_logo_image'    => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Image Logo', 'outsourceo' ),
		],
	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout2' ] ]
	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'group'      => esc_html__( 'Images size for logo ', 'outsourceo' ),
		'prefix'     => 'outsourceo_logo_',
		'dependency' => [ 'template', [ 'outsourceo_layout2' ] ]
	] );
}