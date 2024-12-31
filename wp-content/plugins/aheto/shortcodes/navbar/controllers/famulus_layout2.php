<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'famulus_navbar_layout2');


/**
 * Navbar
 */

function famulus_navbar_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Navbar 3', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);


	$shortcode->add_dependecy('famulus_menus', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_title', 'template', 'famulus_layout2');
	$shortcode->add_params([
		'famulus_menus' => [
			'type'        => 'select',
			'heading'     => esc_html__('Menu', 'famulus'),
			'options'     => \Aheto\Helper::choices_nav_menu(),
			'description' => esc_html__('Use menu with one level items', 'famulus'),
		],
		'famulus_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Menu Title', 'famulus'),
		],
		'famulus_links_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links color', 'bizy' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-navbar--famulus-menu-additional ul li a' => 'color: {{VALUE}}' ],
		],
		'famulus_links_hover_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links hover color', 'bizy' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-navbar--famulus-menu-additional ul li:hover a' => 'color: {{VALUE}}!important' ],
		]

	]);
}
