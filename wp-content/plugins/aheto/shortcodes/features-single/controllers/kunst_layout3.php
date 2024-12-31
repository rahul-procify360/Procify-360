<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_features-single_register', 'kunst_features_single_layout3' );

/**
 * Kunst Features Single
 */

function kunst_features_single_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'kunst_layout3' , [
		'title' => esc_html__( 'Kunst Years', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout3.jpg',
	]);

	aheto_demos_add_dependency( [ 't_heading', 'use_heading', 't_description', 'use_description' ], [ 'kunst_layout3' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_link_title', 'template', [ 'kunst_layout3' ] );
	$shortcode->add_dependecy( 'kunst_title', 'template', [ 'kunst_layout3' ] );
	$shortcode->add_dependecy( 'kunst_desc', 'template', [ 'kunst_layout3' ] );
	$shortcode->add_dependecy( 'kunst_vertical_line', 'template', [ 'kunst_layout3' ] );
	$shortcode->add_dependecy( 'kunst_bg_color1', 'template', [ 'kunst_layout3' ] );

	$shortcode->add_dependecy( 'kunst_year', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_year_desc', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_year_desc', 'template', 'kunst_layout3' );

	$shortcode->add_dependecy( 'kunst_year_use_typo', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_year_typo', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_year_typo', 'kunst_year_use_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_year_desc_use_typo', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_year_desc_typo', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_year_desc_typo', 'kunst_year_desc_use_typo', 'true' );

	$shortcode->add_params([

		'kunst_link_title'       => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link', 'kunst' ),
			'default' => esc_html__( '#', 'kunst' ),
		],
		'kunst_title'       => [
			'type'    => 'text',
			'heading' => esc_html__(' Title', 'kunst' ),
		],
		'kunst_desc'        => [
			'type'    => 'textarea',
			'heading' => esc_html__( 'Description', 'kunst') ,
		],
		'kunst_vertical_line' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use Year right Vertical Line', 'kunst' ),
			'grid'    => 1,
		],
		'kunst_bg_color1' => [
			'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background Hover Color', 'kunst' ),
            'grid'      => 6,
            'selectors' => [
            	'{{WRAPPER}} .aheto-content-block--kunst__year::before' => 'background: {{VALUE}}'
            ],
		],


		'kunst_year'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'Year', 'kunst' ),
		],
		'kunst_year_desc'  => [
			'type'    => 'text',
			'heading' => esc_html__( 'Year Description', 'kunst' ),
		],

		'kunst_year_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Year?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_year_typo'     => [
			'type'     => 'typography',
			'group'    => 'Kunst Year Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__year',
		],

		'kunst_year_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Year Description?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_year_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Kunst Year Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__year-desc',
		],

    ]);

}

function kunst_features_single_layout3_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_year_use_typo']) && !empty($shortcode->atts['kunst_year_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__year'], $shortcode->parse_typography($shortcode->atts['kunst_year_typo']));
	}

	if ( !empty($shortcode->atts['kunst_year_desc_use_typo']) && !empty($shortcode->atts['kunst_year_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__year-desc'], $shortcode->parse_typography($shortcode->atts['kunst_year_desc_typo']));
	}

	return $css;

}

add_filter( 'aheto_features_single_dynamic_css', 'kunst_features_single_layout3_dynamic_css', 10, 2 );
