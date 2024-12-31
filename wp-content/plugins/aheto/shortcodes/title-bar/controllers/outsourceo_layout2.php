<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_title-bar_register', 'outsourceo_title_bar_layout2' );

/**
 * Title Bar Shortcode
 */

function outsourceo_title_bar_layout2( $shortcode ) {

	$dir = '//assets.aheto.co/title-bar/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Title Bar 7', 'outsourceo' ),
		'image' => $dir . 'outsourceo_layout2.jpg',
	] );

	aheto_demos_add_dependency( ['breadcrumb_type', 'custom_breadcrumb', 'links_color'], [ 'outsourceo_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_use_breadcrumb_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_breadcrumb_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_breadcrumb_typo', 'outsourceo_use_breadcrumb_typo', 'true' );

	$shortcode->add_params( [
		'outsourceo_use_breadcrumb_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for breadcrumbs?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_breadcrumb_typo'     => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Breadcrumbs Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aht-breadcrumbs__item, {{WRAPPER}} .aht-breadcrumbs__item a',
		],
	] );

}



function outsourceo_title_bar_layout2_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_breadcrumb_typo'] ) && ! empty( $shortcode->atts['outsourceo_breadcrumb_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aht-breadcrumbs__item, %1$s .aht-breadcrumbs__item a'], $shortcode->parse_typography( $shortcode->atts['outsourceo_breadcrumb_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_title_bar_dynamic_css', 'outsourceo_title_bar_layout2_shortcode_dynamic_css', 10, 2 );