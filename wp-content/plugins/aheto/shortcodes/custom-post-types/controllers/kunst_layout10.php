<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'kunst_custom_post_types_layout10' );

/**
 * Custom post type Shortcode
 */

function kunst_custom_post_types_layout10( $shortcode ) {

    $preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'kunst_layout10', [
		'title' => esc_html__( 'Kunst 3D', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout10.jpg',
	]);

	aheto_demos_add_dependency( [ 't_heading', 'use_heading' ], [ 'kunst_layout10' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_use_excerpt_typo', 'template', [ 'kunst_layout10' ] );
	$shortcode->add_dependecy( 'kunst_excerpt_text_typo', 'template', [ 'kunst_layout10' ] );
	$shortcode->add_dependecy( 'kunst_excerpt_text_typo', 'kunst_use_excerpt_typo', 'true' );

	$shortcode->add_params( [

		'kunst_use_excerpt_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Excerpt?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_excerpt_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Kunst Excerpt Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .cat',
		],

    ]);

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'kunst_swiper_',
        'include'        => [ 'arrows', 'effect', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'kunst_layout10' ] ]
    ]);

}

function kunst_custom_post_types_layout10_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_excerpt_typo']) && !empty($shortcode->atts['kunst_excerpt_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .cat'], $shortcode->parse_typography($shortcode->atts['kunst_excerpt_text_typo']));
	}

	return $css;

}

add_filter( 'aheto_dynamic_css_custom_post_types', 'kunst_custom_post_types_layout10_dynamic_css', 10, 2 );
