<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'sterling_navigation_layout1');

/**
 * Navigation
 */

function sterling_navigation_layout1($shortcode)
{

	$dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling navigation with logo in center', 'sterling'),
		'image' => $dir . 'sterling_layout1.jpg',
	]);

	$shortcode->add_dependecy('sterling_use_navmenu_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_navmenu_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_navmenu_typo', 'sterling_use_navmenu_typo', 'true');

	$shortcode->add_dependecy('sterling_menus_right', 'template', 'sterling_layout1');

	$shortcode->add_dependecy('sterling_use_links_typo', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_links_typo', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_links_typo', 'sterling_use_links_typo', 'true');

	$shortcode->add_dependecy('sterling_dropdown_icon_color', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_dropdown_icon_size', 'template', ['sterling_layout1']);

	$shortcode->add_dependecy('sterling_net_icon_color', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_net_icon_size', 'template', ['sterling_layout1']);

	$shortcode->add_dependecy('sterling_search_icon_color', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_search_icon_size', 'template', ['sterling_layout1']);

	$shortcode->add_dependecy('sterling_cart_use_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_cart_typo', 'sterling_cart_use_typo', 'true');

	aheto_demos_add_dependency(['networks', 'transparent', 'search', 'mini_cart', 'logo','mob_logo', 'add_scroll_logo', 'scroll_logo', 'type_logo'], ['sterling_layout1'], $shortcode);

	$shortcode->add_params([
		'sterling_menus_right'         => [
			'type'        => 'select',
			'heading'     => esc_html__('Right Menu', 'sterling'),
			'options'     => \Aheto\Helper::choices_nav_menu(),
			'descript
			ion' => esc_html__('Use menu with one level items', 'sterling'),
		],
		'sterling_use_links_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_links_typo' => [
			'type'     => 'typography',
			'group'    => 'Navigation Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu li a',
		],
		'sterling_dropdown_icon_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Dropdown Icon Color', 'sterling'),
			'selectors' => ['{{WRAPPER}} .dropdown-btn' => 'color: {{VALUE}}'],
		],
		'sterling_dropdown_icon_size'   => [
			'type'     => 'text',
			'heading'   => esc_html__('Dropdown Icon Size', 'sterling'),
			'selectors' => ['{{WRAPPER}} .dropdown-btn' => 'font-size: {{VALUE}}'],
		],
		'sterling_net_icon_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Networks Icon Color', 'sterling'),
			'selectors' => ['{{WRAPPER}} .main-header__icon' => 'color: {{VALUE}}'],
		],
		'sterling_net_icon_size'   => [
			'type'     => 'text',
			'heading'   => esc_html__('Networks Icon Size', 'sterling'),
			'selectors' => ['{{WRAPPER}} .main-header__icon' => 'font-size: {{VALUE}}'],
		],
		'sterling_search_icon_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Search/Cart Icon Color', 'sterling'),
			'selectors' => ['{{WRAPPER}} .icons-widget__link' => 'color: {{VALUE}}'],
		],
		'sterling_search_icon_size'   => [
			'type'     => 'text',
			'heading'   => esc_html__('Search/Cart Icon Size', 'sterling'),
			'selectors' => ['{{WRAPPER}} .icons-widget__link' => 'font-size: {{VALUE}}'],
		],
		'sterling_cart_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Cart Number?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_cart_typo'     => [
			'type'     => 'typography',
			'group'    => 'Cart Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .main-header__widget-box .button-number',
		],

		'sterling_use_navmenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for submenu items with images?', 'sterling' ),
			'grid'    => 3,
			'label_block'  => true,
		],

		'sterling_navmenu_typo'     => [
			'type'     => 'typography',
			'group'    => 'Sterling Submenu with Images Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__main-line .main-header__pages-list li a',
		],
	]);
}
