<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'moovit_navbar_layout2' );


/**
 * Navbar
 */

function moovit_navbar_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Navbar 11', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_menus', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_transparent', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_fixed_menu', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_use_menu_typo', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_menu_typo', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_menu_typo', 'moovit_use_menu_typo', 'true' );


	$shortcode->add_params( [

		'moovit_menus' => [
			'type'        => 'select',
			'heading'     => esc_html__( 'Additional Menu', 'moovit' ),
			'options'     => \Aheto\Helper::choices_nav_menu(),
			'description' => esc_html__( 'Use menu with one level items', 'moovit' ),
		],

		'moovit_transparent' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Type of menu', 'moovit' ),
			'options' => [
				'transparent_dark'  => esc_html__( 'Dark', 'moovit' ),
				'transparent_white' => esc_html__( 'White', 'moovit' ),
			],
		],
		'moovit_fixed_menu'  => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable fixed additional menu on scroll?', 'moovit' ),
			'grid'    => 6,
		],

		'moovit_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for menu?', 'moovit' ),
			'grid'    => 6,
		],

		'moovit_menu_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Menu Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar--inner ul li a',
		],

	] );

}

function moovit_navbar_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_menu_typo'] ) && ! empty( $shortcode->atts['moovit_menu_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-navbar--inner ul li a'], $shortcode->parse_typography( $shortcode->atts['moovit_menu_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_navbar_dynamic_css', 'moovit_navbar_layout2_dynamic_css', 10, 2 );