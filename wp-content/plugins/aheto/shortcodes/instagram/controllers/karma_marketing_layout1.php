<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_instagram_register', 'karma_marketing_instagram_layout1' );

/**
 * Instagram
 */

function karma_marketing_instagram_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/instagram/previews/';

	$shortcode->add_layout( 'karma_marketing_layout1', [
		'title' => esc_html__( 'Instagram 4', 'karma' ),
		'image' => $preview_dir . 'karma_marketing_layout1.jpg',
	] );

    aheto_demos_add_dependency( [ 'limit', 'size' ], [ 'karma_marketing_layout1' ], $shortcode );

	$shortcode -> add_dependecy ( 'karma_marketing_use_username_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_username_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_username_typo', 'karma_marketing_use_username_typo', 'true' );

	$shortcode->add_params( [

		'karma_marketing_use_username_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for username?', 'karma' ),
			'grid' => 3,
		],
		'karma_marketing_username_typo' => [
			'type' => 'typography',
			'group' => 'Username Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-instagram__username, {{WRAPPER}} .aheto-instagram__username a',
		],

	] );
}

function karma_marketing_instagram_layout1_dynamic_css ( $css, $shortcode ) {

	if ( !empty( $shortcode -> atts['karma_marketing_use_username_typo'] ) && !empty( $shortcode -> atts['karma_marketing_username_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-instagram__username, %1$s .aheto-instagram__username a'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_username_typo'] ) );
	}

	return $css;

}

add_filter ( 'aheto_instagram_dynamic_css', 'karma_marketing_instagram_layout1_dynamic_css', 10, 2 );

