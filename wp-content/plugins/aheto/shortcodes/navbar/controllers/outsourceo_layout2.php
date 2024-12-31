<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'outsourceo_navbar_layout2' );

/**
 * Navbar Shortcode
 */

function outsourceo_navbar_layout2( $shortcode ) {
	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Navbar 14', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_menus', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_transparent', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_fixed_menu', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_use_menu_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_menu_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_menu_typo', 'outsourceo_use_menu_typo', 'true' );

	$shortcode->add_params( [
		'outsourceo_menus'         => [
			'type'        => 'select',
			'heading'     => esc_html__( 'Additional Menu', 'outsourceo' ),
			'options'     => \Aheto\Helper::choices_nav_menu(),
			'description' => esc_html__( 'Use menu with one level items', 'outsourceo' ),
		],
		'outsourceo_transparent'   => [
			'type'    => 'select',
			'heading' => esc_html__( 'Type of menu', 'outsourceo' ),
			'options' => [
				'transparent_dark'  => esc_html__( 'Dark', 'outsourceo' ),
				'transparent_white' => esc_html__( 'White', 'outsourceo' ),
			],
		],
		'outsourceo_fixed_menu'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable fixed additional menu on scroll?', 'outsourceo' ),
			'grid'    => 6,
		],
		'outsourceo_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for menu?', 'outsourceo' ),
			'grid'    => 6,
		],
		'outsourceo_menu_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Menu Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar--inner ul li a',
		],
	] );
}

function outsourceo_navbar_layout2_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['aira_use_menu_typo'] ) && ! empty( $shortcode->atts['aira_menu_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-navbar--inner ul li a'], $shortcode->parse_typography( $shortcode->atts['aira_menu_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_navbar_dynamic_css', 'outsourceo_navbar_layout2_shortcode_dynamic_css', 10, 2 );