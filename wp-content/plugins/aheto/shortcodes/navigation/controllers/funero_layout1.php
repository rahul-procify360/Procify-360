<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'funero_navigation_layout1');

/**
 *  Navigation Shortcode
 */

/**
 * Navigation Shortcode
 */
function funero_navigation_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Navigation 7', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);


	$shortcode->add_dependecy('funero_use_menu_link_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_menu_link_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_menu_link_typo', 'funero_use_menu_link_typo', 'true');
	$shortcode->add_dependecy('funero_use_submenu_link_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_submenu_link_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_submenu_link_typo', 'funero_use_submenu_link_typo', 'true');
	$shortcode->add_dependecy('funero_use_mega_menu_title_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_mega_menu_title_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_mega_menu_title_typo', 'funero_use_mega_menu_title_typo', 'true');
	$shortcode->add_dependecy('funero_use_desk_menu_link_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_desk_menu_link_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_desk_menu_link_typo', 'funero_use_desk_menu_link_typo', 'true');
	$shortcode->add_dependecy('funero_desk_menu', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_use_logo_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_use_logo_typo', 'type_logo', 'text');
	$shortcode->add_dependecy('funero_logo_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_logo_typo', 'funero_use_logo_typo', 'true');
	$shortcode->add_dependecy('funero_menu_right', 'template', 'funero_layout1');


	aheto_demos_add_dependency(['max_width','mob_logo','add_scroll_logo','scroll_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'transparent', 'type_logo', 'logo', 'text_logo','search', 'mobile_menu_width', 'mob_menu_title_typo', 'use_mob_menu_title_typo'], ['funero_layout1'], $shortcode);


	$shortcode->add_params([

		'funero_desk_menu' => [
			'type'    => 'select',
			'heading' => esc_html__('Desktop menu', 'funero'),
			'options' => Helper::choices_nav_menu(),
		],

		'funero_use_desk_menu_link_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Desktop menu links?', 'funero'),
			'grid'    => 3,
		],
		'funero_desk_menu_link_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Desktop menu links Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .desk-menu__container .menu-item a',
		],
		'funero_use_menu_link_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu links?', 'funero'),
			'grid'    => 3,
		],
		'funero_menu_link_typo'           => [
			'type'     => 'typography',
			'group'    => 'Funero Menu links Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-home-page-container .menu-item a',
		],
		'funero_use_submenu_link_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for submenu links?', 'funero'),
			'grid'    => 3,
		],
		'funero_submenu_link_typo'        => [
			'type'     => 'typography',
			'group'    => 'Funero Submenu links Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-home-page-container .menu-item .sub-menu a',
		],
		'funero_use_logo_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for logo?', 'funero'),
			'grid'    => 3,
		],
		'funero_logo_typo'                => [
			'type'     => 'typography',
			'group'    => 'Funero Logo Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__logo span',
		],
		'funero_use_mega_menu_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for mega menu title?', 'funero'),
			'grid'    => 3,
		],
		'funero_mega_menu_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Mega Menu Title Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .mega-menu__title',
		],
		'funero_menu_right'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Align menu to the right side?', 'funero'),
			'grid'    => 3,
		],
	]);

}

function funero_navigation_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['funero_use_desk_menu_link_typo']) && $shortcode->atts['funero_use_desk_menu_link_typo'] && isset($shortcode->atts['funero_desk_menu_link_typo']) && !empty($shortcode->atts['funero_desk_menu_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .desk-menu__container .menu-item a'], $shortcode->parse_typography($shortcode->atts['funero_desk_menu_link_typo']));
	}
	if ( isset($shortcode->atts['funero_use_menu_link_typo']) && $shortcode->atts['funero_use_menu_link_typo'] && isset($shortcode->atts['funero_menu_link_typo']) && !empty($shortcode->atts['funero_menu_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .menu-home-page-container .menu-item a'], $shortcode->parse_typography($shortcode->atts['funero_menu_link_typo']));
	}
	if ( isset($shortcode->atts['funero_use_submenu_link_typo']) && $shortcode->atts['funero_use_submenu_link_typo'] && isset($shortcode->atts['funero_submenu_link_typo']) && !empty($shortcode->atts['funero_submenu_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .menu-home-page-container .menu-item .sub-menu a'], $shortcode->parse_typography($shortcode->atts['funero_submenu_link_typo']));
	}
	if ( isset($shortcode->atts['funero_use_logo_typo']) && $shortcode->atts['funero_use_logo_typo'] && isset($shortcode->atts['funero_logo_typo']) && !empty($shortcode->atts['funero_logo_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography($shortcode->atts['funero_logo_typo']));
	}
	if ( isset($shortcode->atts['funero_use_mega_menu_title_typo']) && $shortcode->atts['funero_use_mega_menu_title_typo'] && isset($shortcode->atts['funero_mega_menu_title_typo'])  && !empty($shortcode->atts['funero_mega_menu_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['funero_mega_menu_title_typo']));
	}
	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'funero_navigation_layout1_dynamic_css', 10, 2);
