<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'moovit_progress_bar_layout1' );
/**
 * Progress Bar Shortcode
 */

function moovit_progress_bar_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Progress Bar 11', 'aheto' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_number', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_image', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_current', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_title_tag', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_use_dot', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_dot_color', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_symbol', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_dot_color', 'moovit_use_dot', 'true' );

	$shortcode->add_dependecy( 'moovit_use_number_typo', 'template',  [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_number_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_number_typo', 'moovit_use_number_typo', 'true' );

	$shortcode->add_dependecy( 'moovit_use_symbol_typo', 'template',  [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_symbol_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_symbol_typo', 'moovit_use_symbol_typo', 'true' );

	aheto_demos_add_dependency( ['description', 'heading'], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_params( [
		'moovit_title_tag' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for heading', 'aheto' ),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h4',
			'grid'    => 4,
		],
		'moovit_use_dot'   => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot at the end of the heading?', 'aheto' ),
			'grid'    => 4,
		],
		'moovit_dot_color' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Color for dot', 'aheto' ),
			'options' => [
				'primary' => esc_html__( 'Primary', 'aheto' ),
				'dark'    => esc_html__( 'Dark', 'aheto' ),
				'white'   => esc_html__( 'White', 'aheto' ),
			],
			'default' => 'primary',
			'grid'    => 4,
		],
		'moovit_image'     => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Image', 'aheto' ),
		],
		'moovit_current'   => [
			'type'    => 'text',
			'heading' => esc_html__( 'Symbol before Number', 'aheto' ),
		],
		'moovit_number'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Number', 'aheto' ),
		],
		'moovit_symbol'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Symbol after Number', 'aheto' ),
		],
		'moovit_use_number_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for numbers?', 'aheto' ),
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

		'moovit_use_symbol_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for symbol?', 'aheto' ),
			'grid'    => 3,
		],

		'moovit_symbol_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Symbol Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__symbol',
		],
	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', ['moovit_layout1']]
	]);
}


function moovit_progress_bar_layout1_dynamic_css( $css, $shortcode ) {

	if ( $shortcode->atts['moovit_use_number_typo'] && ! empty( $shortcode->atts['moovit_number_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__current, %1$s .aheto-counter__number'], $shortcode->parse_typography( $shortcode->atts['moovit_number_typo'] ) );
	}

	if ( $shortcode->atts['moovit_use_symbol_typo'] && ! empty( $shortcode->atts['moovit_symbol_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__current, %1$s .aheto-counter__symbol'], $shortcode->parse_typography( $shortcode->atts['moovit_symbol_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'moovit_progress_bar_layout1_dynamic_css', 10, 2 );