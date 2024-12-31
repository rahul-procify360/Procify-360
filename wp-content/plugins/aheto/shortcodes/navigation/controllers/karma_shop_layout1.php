<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'karma_shop_navigation_layout1');

/**
 *  Banner Slider
 */

function karma_shop_navigation_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('karma_shop_layout1', [
		'title' => esc_html__('Navigation 15', 'karma_shop'),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	]);
	
	aheto_demos_add_dependency(['type_logo', 'text_logo', 'logo', 'mob_logo',  'use_logo_typo', 'logo_typo', 'mobile_menu_width', 'mob_menu_title_typo', 'use_mob_menu_title_typo'], ['karma_shop_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_shop_use_menu_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_menu_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_menu_typo', 'karma_shop_use_menu_typo', 'true');
	
	$shortcode->add_dependecy('karma_shop_use_submenu_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_submenu_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_submenu_typo', 'karma_shop_use_submenu_typo', 'true');
	
	$shortcode->add_dependecy('karma_shop_use_mobmenutitle_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_mobmenutitle_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_mobmenutitle_typo', 'karma_shop_use_mobmenutitle_typo', 'true');

	$shortcode->add_dependecy('karma_shop_use_btnclose_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_btnclose_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_btnclose_typo', 'karma_shop_use_btnclose_typo', 'true');


	$shortcode->add_params([

		'karma_shop_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu?', 'karma_shop'),
			'grid'    => 3,
		],
		'karma_shop_menu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Menu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu li a',
		],
		'karma_shop_use_submenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for submenu?', 'karma_shop' ),
			'grid'    => 3,
		],
		'karma_shop_submenu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Submenu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu .sub-menu li a',
		],
		'karma_shop_use_mobmenutitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for mobile menu title?', 'karma_shop' ),
			'grid'    => 3,
		],
		'karma_shop_mobmenutitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Mobile Menu Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .btn-close::after',
		],
		'karma_shop_use_btnclose_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for close button?', 'karma_shop' ),
			'grid'    => 3,
		],
		'karma_shop_btnclose_typo'        => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Close Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .btn-close i',
		],
	]);
}
function karma_shop_navigation_layout1_dynamic_css($css, $shortcode)
{

	if ($shortcode->atts['karma_shop_use_menu_typo'] && !empty($shortcode->atts['karma_shop_menu_typo'])) {
		\aheto_add_props($css['global']['%1$s .main-menu li a'], $shortcode->parse_typography($shortcode->atts['karma_shop_menu_typo']));
	}
		
	if ( $shortcode->atts['karma_shop_use_submenu_typo'] && !empty($shortcode->atts['karma_shop_submenu_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-menu .sub-menu li a'], $shortcode->parse_typography($shortcode->atts['karma_shop_submenu_typo']));
	}
	
	if ( $shortcode->atts['karma_shop_use_mobmenutitle_typo'] && !empty($shortcode->atts['karma_shop_mobmenutitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__menu-box .btn-close::after'], $shortcode->parse_typography($shortcode->atts['karma_shop_mobmenutitle_typo']));
	}

	if ( $shortcode->atts['karma_shop_use_btnclose_typo'] && !empty($shortcode->atts['karma_shop_btnclose_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__menu-box .btn-close i'], $shortcode->parse_typography($shortcode->atts['karma_shop_btnclose_typo']));
	}

	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'karma_shop_navigation_layout1_dynamic_css', 10, 2);
