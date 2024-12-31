<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'djo_navigation_layout1');

/**
 * Navigation Shortcode
 */

function djo_navigation_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Navigation 3', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);

	$shortcode->add_dependecy( 'djo_burger', 'template', 'djo_layout1');
	$shortcode->add_dependecy( 'djo_hamburger_color', 'template', 'djo_layout1');
	$shortcode->add_dependecy('djo_menus_right', 'template', 'djo_layout1');
	$shortcode->add_dependecy( 'djo_use_logo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_use_logo', 'type_logo', 'text' );
	$shortcode->add_dependecy( 'djo_logo_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_logo_typo', 'djo_use_logo', 'true' );
	$shortcode->add_dependecy( 'djo_use_link', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_link_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_link_typo', 'djo_use_link', 'true' );
	$shortcode->add_dependecy( 'djo_use_menu_title', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_menu_title_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_menu_title_typo', 'djo_use_menu_title', 'true' );
	aheto_demos_add_dependency(['type_logo', 'text_logo','logo', 'add_scroll_logo', 'scroll_logo','mob_logo','add_mob_scroll_logo','scroll_mob_logo', 'mobile_menu_width', 'use_mega_menu_title_typo', 'mega_menu_title_typo'], ['djo_layout1'], $shortcode);


	$shortcode->add_params([
		'djo_menus_right'         => [
			'type'        => 'select',
			'heading'     => esc_html__('Right Menu', 'djo'),
			'options'     => \Aheto\Helper::choices_nav_menu(),
			'description' => esc_html__('Use menu with one level items', 'djo'),
		],
		'djo_burger' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Change mobile burger for two lines?', 'djo' ),
			'grid'    => 6,
		],
		'djo_use_logo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for logo text?', 'djo' ),
			'grid'    => 6,
		],
		'djo_logo_typo' => [
			'type'     => 'typography',
			'group'    => 'Djo Text Logo Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .main-header__logo span',
		],
		'djo_use_link' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for link?', 'djo' ),
			'grid'    => 6,
		],

		'djo_link_typo' => [
			'type'     => 'typography',
			'group'    => 'Djo Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .menu-item a',
		],
		'djo_use_menu_title' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for menu title?', 'djo' ),
			'grid'    => 6,
		],
		'djo_menu_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Djo Menu Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-title',
		],
		'djo_hamburger_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Mobile menu hamburger color', 'snapster' ),
			'grid' => 6,
			'selectors' => [
				'{{WRAPPER}} .hamburger-inner::after' => 'background: {{VALUE}}',
				'{{WRAPPER}} .hamburger-inner::before' => 'background: {{VALUE}}',
				'{{WRAPPER}} .hamburger-inner' => 'background: {{VALUE}}',
			],
		],
	]);
}
function djo_navigation_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_logo']) && $shortcode->atts['djo_use_logo'] && isset($shortcode->atts['djo_logo_typo']) && !empty($shortcode->atts['djo_logo_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography($shortcode->atts['djo_logo_typo']));
	}
	if ( isset($shortcode->atts['djo_use_link']) && $shortcode->atts['djo_use_link'] && isset($shortcode->atts['djo_link_typo']) && !empty($shortcode->atts['djo_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .menu-item a'], $shortcode->parse_typography($shortcode->atts['djo_link_typo']));
	}
	if ( isset($shortcode->atts['djo_use_menu_title']) && $shortcode->atts['djo_use_menu_title'] && isset($shortcode->atts['djo_menu_title_typo']) && !empty($shortcode->atts['djo_menu_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .menu-title'], $shortcode->parse_typography($shortcode->atts['djo_menu_title_typo']));
	}
	if (isset($shortcode->atts['djo_hamburger_color']) && !empty($shortcode->atts['djo_hamburger_color'])) {
		$color = Sanitize::color($shortcode->atts['djo_hamburger_color']);
		$css['global']['%1$s .hamburger-inner::after']['background'] = $color;
		$css['global']['%1$s .hamburger-inner::before']['background'] = $color;
		$css['global']['%1$s .hamburger-inner']['background'] = $color;
	}


	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'djo_navigation_layout1_dynamic_css', 10, 2);
