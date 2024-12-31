<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_navigation_register', 'ninedok_navigation_layout1' );


/**
 * Navbar
 */

function ninedok_navigation_layout1 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Navigation 19', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );


	aheto_demos_add_dependency ( ['type_logo', 'text_logo', 'logo','mob_logo', 'transparent', 'label_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'mobile_menu_width'], [ 'ninedok_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'ninedok_use_label', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_label', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_label', 'ninedok_use_label', 'true' );

	$shortcode->add_dependecy( 'ninedok_use_mega_menu_title', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_mega_menu_title', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_mega_menu_title', 'ninedok_use_mega_menu_title', 'true' );

	$shortcode->add_dependecy( 'ninedok_use_mega_menu_link', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_mega_menu_link', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_mega_menu_link', 'ninedok_use_mega_menu_link', 'true' );

	$shortcode->add_dependecy( 'ninedok_use_menu_link', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_menu_link', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_t_menu_link', 'ninedok_use_menu_link', 'true' );

	$shortcode->add_params( [
		'ninedok_use_label'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for label?', 'ninedok'),
			'grid'    => 6,
		],
		'ninedok_t_label'       => [
			'type'     => 'typography',
			'group'    => 'Ninedok Label Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__logo-label',
		],
		'ninedok_use_mega_menu_title'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Mega menu title?', 'ninedok'),
			'grid'    => 6,
		],
		'ninedok_t_mega_menu_title'       => [
			'type'     => 'typography',
			'group'    => 'Ninedok Mega Menu Title Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .mega-menu__title',
		],
		'ninedok_use_mega_menu_link'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for submenu link?', 'ninedok'),
			'grid'    => 6,
		],
		'ninedok_t_mega_menu_link'       => [
			'type'     => 'typography',
			'group'    => 'Ninedok Submenu Link Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} ul li ul a',
		],
		'ninedok_use_menu_link'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu link?', 'ninedok'),
			'grid'    => 6,
		],
		'ninedok_t_menu_link'       => [
			'type'     => 'typography',
			'group'    => 'Ninedok Menu Link Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu > li > a',
		],
	] );


	\Aheto\Params ::add_button_params ( $shortcode, [
		'add_button' => true,
		'prefix' => 'ninedok_main_',
		'group' => 'Desktop buttons',
		'icons' => true,
		'dependency' => [ 'template', [ 'ninedok_layout1' ] ]
	] );
	\Aheto\Params ::add_button_params ( $shortcode, [
		'add_button' => true,
		'prefix' => 'ninedok_main_mob_',
		'group' => 'Mobile Buttons',
		'icons' => true,
		'dependency' => [ 'template', [ 'ninedok_layout1' ] ]
	] );
}
function ninedok_navigation_layout1_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['ninedok_use_label']) && !empty($shortcode->atts['ninedok_t_label'])) {
		\aheto_add_props($css['global']['%1$s .main-header__logo-label'], $shortcode->parse_typography($shortcode->atts['ninedok_t_label']));
	}

	if (!empty($shortcode->atts['ninedok_use_mega_menu_title']) && !empty($shortcode->atts['ninedok_t_mega_menu_title'])) {
		\aheto_add_props($css['global']['%1$s .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['ninedok_t_mega_menu_title']));
	}

	if (!empty($shortcode->atts['ninedok_use_mega_menu_link']) && !empty($shortcode->atts['ninedok_t_mega_menu_link'])) {
		\aheto_add_props($css['global']['%1$s .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['ninedok_t_mega_menu_link']));
	}
	if (!empty($shortcode->atts['ninedok_use_menu_link']) && !empty($shortcode->atts['ninedok_t_menu_link'])) {
		\aheto_add_props($css['global']['%1$s .main-menu li a'], $shortcode->parse_typography($shortcode->atts['ninedok_t_menu_link']));
	}


	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'ninedok_navigation_layout1_dynamic_css', 10, 2);
