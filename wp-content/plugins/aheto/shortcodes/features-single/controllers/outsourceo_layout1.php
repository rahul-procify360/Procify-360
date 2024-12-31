<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_features-single_register', 'outsourceo_features_single_layout1' );

/**
 * Features Single Shortcode
 */

function outsourceo_features_single_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Features Single 40', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );


	// LAYOUT 1
	$shortcode->add_dependecy( 'outsourceo_use_dot', 'template', [ 'outsourceo_layout1' ] );
	$shortcode->add_dependecy( 'outsourceo_link_url', 'template', [ 'outsourceo_layout1' ] );
	$shortcode->add_dependecy( 'outsourceo_link_text', 'template', [ 'outsourceo_layout1' ] );
	$shortcode->add_dependecy( 'outsourceo_background_hover_color', 'template', [ 'outsourceo_layout1'] );

	aheto_demos_add_dependency( ['s_image', 's_heading', 'use_heading', 't_heading', 's_description', 'use_description', 't_description'], [ 'outsourceo_layout1'], $shortcode );

	$shortcode->add_params( [
		'outsourceo_use_dot'       => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot in the end heading?', 'outsourceo' ),
			'grid'    => 12,
		],
		'outsourceo_link_text'     => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link Text', 'outsourceo' ),
			'default' => 'Click Me'
		],
		'outsourceo_link_url'      => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link URL', 'outsourceo' ),
			'default' => '#'
		],
		'outsourceo_background_hover_color' => [
			'type'    => 'colorpicker',
			'heading' => esc_html__( 'Background Hover Color', 'outsourceo' ),
			'grid'    => 12,
			'default' => '',
			'selectors' => [ '{{WRAPPER}} .aheto-content-block__wrap:hover' => 'background: {{VALUE}}' ],
		],
	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout1'] ]
	] );

}

function outsourceo_features_single_layout1_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_background_hover_color'] ) ) {
		$color                               = Sanitize::color( $shortcode->atts['color'] );
		$css['global']['%1$s .aheto-content-block__wrap:hover']['color'] = $color;
	}

	return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'outsourceo_features_single_layout1_shortcode_dynamic_css', 10, 2 );