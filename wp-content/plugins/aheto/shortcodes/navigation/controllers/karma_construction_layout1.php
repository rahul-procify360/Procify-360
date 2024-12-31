<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'karma_construction_navigation_layout1');


/**
 * Navigation Shortcode
 */

function karma_construction_navigation_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('karma_construction_layout1', [
		'title' => esc_html__('Navigation 11', 'karma'),
		'image' => $preview_dir . 'karma_construction_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_construction_use_menu_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_menu_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_menu_typo', 'karma_construction_use_menu_typo', 'true');

	$shortcode->add_dependecy('karma_construction_title_use_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_title_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_title_typo', 'karma_construction_title_use_typo', 'true');

	$shortcode->add_dependecy('karma_construction_contact_use_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_contact_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_contact_typo', 'karma_construction_contact_use_typo', 'true');

	$shortcode->add_dependecy('karma_construction_icon_use_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_icon_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_icon_typo', 'karma_construction_icon_use_typo', 'true');

	$shortcode->add_dependecy('karma_construction_phone_title', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_address_title', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_phone', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_address', 'template', 'karma_construction_layout1');

	aheto_demos_add_dependency(['list_space', 'type_logo', 'logo', 'hovercolor', 'search', 'mini_cart', 'mobile_menu_width', 'use_mob_menu_title_typo', 'mob_menu_title_typo'], ['karma_construction_layout1'], $shortcode);

	$shortcode->add_params([
		'karma_construction_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu text?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_phone_title'   => [
			'type'    => 'text',
			'heading' => esc_html__('Phone Title', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_address_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Address Title', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_phone'         => [
			'type'    => 'text',
			'heading' => esc_html__('Phone', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_address'       => [
			'type'    => 'text',
			'heading' => esc_html__('Address', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_menu_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Menu Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} ul.main-menu > li > a, {{WRAPPER}}  ul.sub-menu > li > a',
		],
		'karma_construction_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu title?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Menu Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__details-title',
		],
		'karma_construction_contact_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu contact?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_contact_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Menu Contact Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__details-text a, {{WRAPPER}} .main-header__details-text p',
		],
		'karma_construction_icon_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu icon?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_icon_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Menu Icon Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .icons-widget__link i',
		],
	]);
	\Aheto\Params::add_icon_params($shortcode, [
		'prefix'     => 'karma_construction_phone_',
		'group'      => 'Karma Construction Phone Icon',
		'add_icon'   => true,
		'exclude'    => ['align'],
		'dependency' => ['template', ['karma_construction_layout1']]
	]);
	\Aheto\Params::add_icon_params($shortcode, [
		'prefix'     => 'karma_construction_address_',
		'group'      => 'Karma Construction Address Icon',
		'add_icon'   => true,
		'exclude'    => ['align'],
		'dependency' => ['template', ['karma_construction_layout1']]
	]);
}

function karma_construction_navigation_layout1_dynamic_css($css, $shortcode) {
	if ( !empty($shortcode->atts['karma_construction_use_menu_typo']) && !empty($shortcode->atts['karma_construction_menu_typo']) ) {
		\aheto_add_props($css['global']['%1$s ul.main-menu > li > a, ul.sub-menu > li > a'], $shortcode->parse_typography($shortcode->atts['karma_construction_menu_typo']));
	}
	if ( !empty($shortcode->atts['karma_construction_title_use_typo']) && !empty($shortcode->atts['karma_construction_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__details-title'], $shortcode->parse_typography($shortcode->atts['karma_construction_title_typo']));
	}
	if ( !empty($shortcode->atts['karma_construction_contact_use_typo']) && !empty($shortcode->atts['karma_construction_contact_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .main-header__details-text a, %1$s .main-header__details-text p'], $shortcode->parse_typography($shortcode->atts['karma_construction_contact_typo']));
	}
	if ( !empty($shortcode->atts['karma_construction_icon_use_typo']) && !empty($shortcode->atts['karma_construction_icon_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .icons-widget__link i'], $shortcode->parse_typography($shortcode->atts['karma_construction_icon_typo']));
	}

	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'karma_construction_navigation_layout1_dynamic_css', 10, 2);