<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_progress-bar_register', 'outsourceo_progress_bar_layout1' );


/**
 * Progress Bar
 */

function outsourceo_progress_bar_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'OProgress Bar 16', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_current', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_symbol', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_use_dot', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_align', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_use_position_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_position_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_position_typo', 'outsourceo_use_position_typo', 'true' );
	$shortcode->add_dependecy( 'outsourceo_use_descr_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_descr_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_descr_typo', 'outsourceo_use_descr_typo', 'true' );

	aheto_demos_add_dependency( ['percentage', 'description'], [ 'outsourceo_layout1' ], $shortcode );

	$shortcode->add_params( [
		'outsourceo_current'   => [
			'type'    => 'text',
			'heading' => esc_html__( 'Symbol before percent', 'outsourceo' ),
		],
		'outsourceo_symbol'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Symbol after percent', 'outsourceo' ),
		],
		'outsourceo_use_dot'           => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot at the end of the number?', 'outsourceo' ),
			'grid'    => 12,
		],
		'outsourceo_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for numbers?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_position_typo'     => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Numbers Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__number, {{WRAPPER}} .aheto-counter__current, {{WRAPPER}} .aheto-counter__symbol',
		],
		'outsourceo_use_descr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_descr_typo'     => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Description Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__desc',
		],
		'outsourceo_align'             => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align', 'outsourceo' ),
			'options' => \Aheto\Helper::choices_alignment(),
		],
	] );
}

function outsourceo_progress_bar_layout1_dynamic_css( $css, $shortcode ) {

	if (isset( $shortcode->atts['outsourceo_use_position_typo'] ) && $shortcode->atts['outsourceo_use_position_typo'] && isset($shortcode->atts['outsourceo_position_typo']) && ! empty( $shortcode->atts['outsourceo_position_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__number, %1$s .aheto-counter__current,  %1$s .aheto-counter__symbol'], $shortcode->parse_typography( $shortcode->atts['outsourceo_position_typo'] ) );
	}

	if (isset( $shortcode->atts['outsourceo_use_descr_typo'] ) && $shortcode->atts['outsourceo_use_descr_typo'] && isset($shortcode->atts['outsourceo_descr_typo']) && ! empty( $shortcode->atts['outsourceo_descr_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__desc'], $shortcode->parse_typography( $shortcode->atts['outsourceo_descr_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'outsourceo_progress_bar_layout1_dynamic_css', 10, 2 );