<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_heading_register', 'karma_political_heading_layout1' );

/**
 * Heading
 */

function karma_political_heading_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Heading 12', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
	] );

    $shortcode->add_dependecy( 'karma_political_subtitle', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_subtitle_tag', 'template', 'karma_political_layout1' );

	$shortcode->add_dependecy( 'karma_political_use_subtitle_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_subtitle_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_subtitle_typo', 'karma_political_use_subtitle_typo', 'true' );

	aheto_demos_add_dependency( [ 'heading', 'alignment', 'use_typo', 'text_typo', 'use_typo_hightlight', 'text_typo_hightlight', 'text_tag' ], [ 'karma_political_layout1' ], $shortcode );

	$shortcode->add_params([

		'karma_political_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Description', 'karma'),
			'description' => esc_html__('Add some text for description', 'karma'),
			'admin_label' => true,
			'default'     => esc_html__('Add some text for description', 'karma'),
		],
		'karma_political_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for description', 'karma'),
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
			'default' => 'p',
			'grid'    => 5,
		],

		'karma_political_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'karma'),
			'grid'    => 3,
		],
		'karma_political_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],

	]);

}

function karma_political_heading_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['karma_political_use_subtitle_typo'] ) && ! empty( $shortcode->atts['karma_political_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography( $shortcode->atts['karma_political_subtitle_typo'] ) );
	}

	return $css;

}

add_filter( 'aheto_heading_dynamic_css', 'karma_political_heading_layout1_dynamic_css', 10, 2 );