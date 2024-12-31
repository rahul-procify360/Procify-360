<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'outsourceo_custom_post_types_layout1' );

/**
 * Custom Post Type Shortcode
 */

function outsourceo_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Custom Post Type 14', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_use_cat_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_cat_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_cat_typo', 'outsourceo_use_cat_typo', 'true' );
	$shortcode->add_dependecy( 'outsourceo_use_author_date_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_author_date_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_author_date_typo', 'outsourceo_use_author_date_typo', 'true' );

	$shortcode->add_params( [
		'outsourceo_use_cat_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for categories?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_cat_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Categories Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt__cats a',
		],

		'outsourceo_use_author_date_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for author and date?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_author_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Author and Date Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt__author-name, {{WRAPPER}} .aheto-cpt__date p',
		]

	] );
}

function outsourceo_cpt_layout1_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_cat_typo'] ) && ! empty( $shortcode->atts['outsourceo_cat_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt__cats a'], $shortcode->parse_typography( $shortcode->atts['outsourceo_cat_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['outsourceo_use_author_date_typo'] ) && ! empty( $shortcode->atts['outsourceo_author_date_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt__author-name, %1$s .aheto-cpt__date p'], $shortcode->parse_typography( $shortcode->atts['outsourceo_author_date_typo'] ) );
	}


	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'outsourceo_cpt_layout1_shortcode_dynamic_css', 10, 2 );


function outsourceo_cpt_image_sizer( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'outsourceo_layout1';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'outsourceo_cpt_image_sizer', 10, 2 );