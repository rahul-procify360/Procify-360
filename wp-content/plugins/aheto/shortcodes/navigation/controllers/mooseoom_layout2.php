<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'mooseoom_navigation_layout2');

/**
 *  Banner Slider
 */

function mooseoom_navigation_layout2($shortcode)
{

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('mooseoom_layout2', [
		'title' => esc_html__('Navigation 17', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout2.jpg',
	]);

	aheto_demos_add_dependency(['type_logo', 'text_logo', 'logo', 'mob_logo', 'networks', 'mobile_menu_width'], ['mooseoom_layout2'], $shortcode);

    $shortcode->add_dependecy('mooseoom_use_menu_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_menu_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_menu_typo', 'mooseoom_use_menu_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_submenu_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_submenu_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_submenu_typo', 'mooseoom_use_submenu_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_mobmenutitle_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_mobmenutitle_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_mobmenutitle_typo', 'mooseoom_use_mobmenutitle_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_btnclose_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_btnclose_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_btnclose_typo', 'mooseoom_use_btnclose_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_megamenu_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_megamenu_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_megamenu_typo', 'mooseoom_use_megamenu_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_megamenuitem_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_megamenuitem_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_megamenuitem_typo', 'mooseoom_use_megamenuitem_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_submenuactive_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_submenuactive_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_submenuactive_typo', 'mooseoom_use_submenuactive_typo', 'true');


	$shortcode->add_params([
		'mooseoom_use_submenuactive_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for active submenu?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_submenuactive_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Active Submenu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu ul li.current-menu-item>a',
		],

		'mooseoom_use_megamenuitem_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for mega menu?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_megamenuitem_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Mega Menu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .mega-menu__list li a',
		],


		'mooseoom_use_megamenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for mega menu title?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_megamenu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Mega Menu Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .mega-menu__title',
		],
		'mooseoom_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_menu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Menu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu li a',
		],
		'mooseoom_use_submenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for submenu?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_submenu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Submenu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu .sub-menu li a',
		],
		'mooseoom_use_mobmenutitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for mobile menu title?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_mobmenutitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Mobile Menu Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .btn-close::after',
		],
		'mooseoom_use_btnclose_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for close button?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_btnclose_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Close Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .btn-close i',
		],
	]);
}
function mooseoom_navigation_layout2_dynamic_css($css, $shortcode)
{
	if (!empty($shortcode->atts['mooseoom_use_submenuactive_typo']) && !empty($shortcode->atts['mooseoom_submenuactive_typo'])) {
		\aheto_add_props($css['global']['%1$s .main-menu ul li.current-menu-item>a'], $shortcode->parse_typography($shortcode->atts['mooseoom_submenuactive_typo']));
	}

	if (!empty($shortcode->atts['mooseoom_use_megamenuitem_typo']) && !empty($shortcode->atts['mooseoom_megamenuitem_typo'])) {
		\aheto_add_props($css['global']['%1$s .mega-menu__list li a'], $shortcode->parse_typography($shortcode->atts['mooseoom_megamenuitem_typo']));
	}

	if (!empty($shortcode->atts['mooseoom_use_megamenu_typo']) && !empty($shortcode->atts['mooseoom_megamenu_typo'])) {
		\aheto_add_props($css['global']['%1$s .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['mooseoom_megamenu_typo']));
	}
	if (!empty($shortcode->atts['mooseoom_use_menu_typo']) && !empty($shortcode->atts['mooseoom_menu_typo'])) {
		\aheto_add_props($css['global']['%1$s .main-menu li a'], $shortcode->parse_typography($shortcode->atts['mooseoom_menu_typo']));
	}

	if (!empty($shortcode->atts['mooseoom_use_submenu_typo']) && !empty($shortcode->atts['mooseoom_submenu_typo'])) {
		\aheto_add_props($css['global']['%1$s .main-menu .sub-menu li a'], $shortcode->parse_typography($shortcode->atts['mooseoom_submenu_typo']));
	}

	if (!empty($shortcode->atts['mooseoom_use_mobmenutitle_typo']) && !empty($shortcode->atts['mooseoom_mobmenutitle_typo'])) {
		\aheto_add_props($css['global']['%1$s .main-header__menu-box .btn-close::after'], $shortcode->parse_typography($shortcode->atts['mooseoom_mobmenutitle_typo']));
	}

	if (!empty($shortcode->atts['mooseoom_use_btnclose_typo']) && !empty($shortcode->atts['mooseoom_btnclose_typo'])) {
		\aheto_add_props($css['global']['%1$s .main-header__menu-box .btn-close i'], $shortcode->parse_typography($shortcode->atts['mooseoom_btnclose_typo']));
	}
	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'mooseoom_navigation_layout2_dynamic_css', 10, 2);
