<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'moovit_progress_bar_layout2' );
/**
 * Progress Bar Shortcode
 */

function moovit_progress_bar_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Progress Bar 12', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_number', 'template', ['moovit_layout2' ] );
	$shortcode->add_dependecy( 'moovit_use_dot', 'template', [ 'moovit_layout2' ] );
	$shortcode->add_dependecy( 'moovit_dot_color', 'template', [ 'moovit_layout2' ] );
	$shortcode->add_dependecy( 'moovit_symbol', 'template', ['moovit_layout2' ] );
	$shortcode->add_dependecy( 'moovit_dot_color', 'moovit_use_dot', 'true' );

	$shortcode->add_dependecy( 'moovit_use_number_typo', 'template',  [ 'moovit_layout2' ] );
	$shortcode->add_dependecy( 'moovit_number_typo', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_number_typo', 'moovit_use_number_typo', 'true' );

	aheto_demos_add_dependency( 'heading', [ 'moovit_layout2' ], $shortcode );

	$shortcode->add_params( [
		'moovit_use_dot'   => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot at the end of the heading?', 'moovit' ),
			'grid'    => 4,
		],
		'moovit_dot_color' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Color for dot', 'moovit' ),
			'options' => [
				'primary' => esc_html__( 'Primary', 'moovit' ),
				'dark'    => esc_html__( 'Dark', 'moovit' ),
				'white'   => esc_html__( 'White', 'moovit' ),
			],
			'default' => 'primary',
			'grid'    => 4,
		],
		'moovit_number'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Number', 'moovit' ),
		],
		'moovit_symbol'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Symbol after Number', 'moovit' ),
		],
		'moovit_use_number_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for numbers?', 'moovit' ),
			'grid'    => 3,
		],

		'moovit_number_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Numbers Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__current, {{WRAPPER}} .aheto-counter__number',
		],
	] );
}


function moovit_progress_bar_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_number_typo'] ) && ! empty( $shortcode->atts['moovit_number_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__current, %1$s .aheto-counter__number'], $shortcode->parse_typography( $shortcode->atts['moovit_number_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'moovit_progress_bar_layout2_dynamic_css', 10, 2 );