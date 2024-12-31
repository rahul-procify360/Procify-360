<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_features-single_register', 'kunst_features_single_layout1' );

/**
 * Kunst Features Single
 */

function kunst_features_single_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'kunst_layout1', [
		'title' => esc_html__( 'Kunst Features Modern', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout1.jpg',
	]);

	aheto_demos_add_dependency( [ 's_heading', 't_heading', 'use_heading', 's_description', 't_description', 'use_description', 's_image', 'link_url', 'link_title' ], [ 'kunst_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_number_section', 'template', [ 'kunst_layout1' ] );

	$shortcode->add_dependecy( 'kunst_use_number_section', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_typo_number_section', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_typo_number_section', 'kunst_use_number_section', 'true' );

	$shortcode->add_dependecy( 'kunst_use_link_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_link_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_link_typo', 'kunst_use_link_typo', 'true' );

	$shortcode->add_params([

		'kunst_number_section'       => [
			'type'    => 'text',
			'heading' => esc_html__( 'Number Section', 'kunst' ),
		],

		'kunst_use_number_section'  => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Number Section?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_typo_number_section'        => [
			'type'     => 'typography',
			'group'    => 'Number Section Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-block__number',
		],

		'kunst_use_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for link?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_link_title'       => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link', 'kunst' ),
			'default' => esc_html__( '#', 'kunst' ),
		],

    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'kunst_',
		'dependency' => [ 'template', [ 'kunst_layout1' ] ]
    ]);

}

function kunst_features_single_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_number_section']) && !empty($shortcode->atts['kunst_typo_number_section']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-block__number'], $shortcode->parse_typography($shortcode->atts['kunst_typo_number_section']));
	}

	if ( !empty($shortcode->atts['kunst_use_link_typo']) && !empty($shortcode->atts['kunst_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-link'], $shortcode->parse_typography($shortcode->atts['kunst_link_typo']));
	}

	return $css;

}

add_filter( 'aheto_features_single_dynamic_css', 'kunst_features_single_layout1_dynamic_css', 10, 2 );
