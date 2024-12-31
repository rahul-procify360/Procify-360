<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_features-single_register', 'kunst_features_single_layout2' );

/**
 * Kunst Features Single
 */

function kunst_features_single_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'kunst_layout2', [
		'title' => esc_html__( 'Kunst Features Modern', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout2.jpg',
	]);

	aheto_demos_add_dependency( [ 's_heading', 't_heading', 'use_heading', 's_description', 't_description', 'use_description', 's_image', 'link_url', 'link_title' ], [ 'kunst_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_hover_image', 'template', [ 'kunst_layout2' ] );
	$shortcode->add_dependecy( 'kunst_use_dot', 'template', [ 'kunst_layout2' ] );

	$shortcode->add_dependecy( 'kunst_use_link_typo', 'template', [ 'kunst_layout2' ] );
	$shortcode->add_dependecy( 'kunst_link_typo', 'template', [ 'kunst_layout2' ] );
	$shortcode->add_dependecy( 'kunst_link_typo', 'kunst_use_link_typo', 'true' );

	$shortcode->add_params([

		'kunst_hover_image' => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Hover Image', 'kunst' ),
			'grid'    => 1,
		],
		'kunst_link_title'       => [
            'type'    => 'text',
            'heading' => esc_html__( 'Link', 'kunst' ),
            'default' => esc_html__( '#', 'kunst' ),
        ],
        'kunst_use_dot'       => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use dot in the end heading?', 'kunst' ),
            'grid'    => 12,
		],

		'kunst_use_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for link?', 'kunst' ),
            'grid'    => 3,
        ],
        'kunst_link_typo'        => [
            'type'     => 'typography',
            'group'    => 'Link Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-link',
        ],

    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'kunst_',
		'dependency' => [ 'template', [ 'kunst_layout2' ] ]
    ]);

}

function kunst_features_single_layout2_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_number_section']) && !empty($shortcode->atts['kunst_typo_number_section']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-block__number'], $shortcode->parse_typography($shortcode->atts['kunst_typo_number_section']));
	}

	return $css;

}

add_filter( 'aheto_features_single_dynamic_css', 'kunst_features_single_layout2_dynamic_css', 10, 2 );
