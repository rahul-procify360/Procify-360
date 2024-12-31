<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'kunst_custom_post_types_layout3' );

/**
 * Custom post type Shortcode
 */

function kunst_custom_post_types_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'kunst_layout3', [
        'title' => esc_html__( 'Kunst Mosaics', 'kunst' ),
        'image' => $preview_dir . 'kunst_layout3.jpg',
	]);

	aheto_demos_add_dependency( [ 't_heading', 'use_heading', 't_term', 'use_term', 'title_tag' ], [ 'kunst_layout3' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_use_date_author_text_typo', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_date_author_text_typo', 'template', 'kunst_layout3' );
	$shortcode->add_dependecy( 'kunst_date_author_text_typo', 'kunst_use_date_author_text_typo', 'true' );

	$shortcode->add_params( [

		'kunst_use_date_author_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for date & author text?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_date_author_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Date & Author Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt--content-author-date',
		],

    ]);

}

function kunst_custom_post_types_layout3_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_date_author_text_typo']) && !empty($shortcode->atts['kunst_date_author_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt--content-author-date'], $shortcode->parse_typography($shortcode->atts['kunst_date_author_text_typo']));
	}

	return $css;

}

add_filter( 'aheto_dynamic_css_custom_post_types', 'kunst_custom_post_types_layout3_dynamic_css', 10, 2 );
