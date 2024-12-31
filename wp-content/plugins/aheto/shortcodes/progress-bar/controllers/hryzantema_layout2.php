<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'hryzantema_progress_bar_layout2');

/**
 * Progress bar shortcode
 */

function hryzantema_progress_bar_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'hryzantema_layout2', [
		'title' => esc_html__( 'Progress Bar 7', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	] );

	aheto_demos_add_dependency(['heading','percentage','description'], ['hryzantema_layout2'], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_heading_tag', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_use_numbers_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_numbers_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_numbers_typo', 'hryzantema_use_numbers_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_descr_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_descr_typo', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_descr_typo', 'hryzantema_use_descr_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_add_plus', 'template', 'hryzantema_layout2' );


	$shortcode->add_params( [
		'hryzantema_heading_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for heading', 'hryzantema' ),
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
			'default' => 'h5',
			'grid'    => 5,
		],
		'hryzantema_add_plus' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Add "+" after number?', 'hryzantema' ),
			'grid'    => 3,
		],
		'hryzantema_use_numbers_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for numbers?', 'hryzantema' ),
			'grid'    => 4,
		],

		'hryzantema_numbers_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Numbers Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__number',
		],
		'hryzantema_use_descr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_descr_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__desc',
		],
	] );
}

function hryzantema_progress_bar_layout2_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_numbers_typo'] ) && $shortcode->atts['hryzantema_use_numbers_typo'] && isset( $shortcode->atts['hryzantema_numbers_typo'] ) && ! empty( $shortcode->atts['hryzantema_numbers_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography( $shortcode->atts['hryzantema_numbers_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_descr_typo'] ) && $shortcode->atts['hryzantema_use_descr_typo'] && isset( $shortcode->atts['hryzantema_descr_typo'] ) && ! empty( $shortcode->atts['hryzantema_descr_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__desc'], $shortcode->parse_typography( $shortcode->atts['hryzantema_descr_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'hryzantema_progress_bar_layout2_dynamic_css', 10, 2 );
