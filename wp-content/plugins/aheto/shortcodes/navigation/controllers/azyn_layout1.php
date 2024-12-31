<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'azyn_navigation_layout1');

/**
 *  Navigation Shortcode
 */

/**
 * Navigation Shortcode
 */
function azyn_navigation_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('azyn_layout1', [
		'title' => esc_html__('Azyn Navigation', 'azyn'),
		'image' => $preview_dir . 'azyn_layout1.jpg',
	]);

	$shortcode->add_dependecy('azyn_use_menu_link_typo', 'template', ['azyn_layout1']);
	$shortcode->add_dependecy('azyn_menu_link_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_menu_link_typo', 'azyn_use_menu_link_typo', 'true');
	$shortcode->add_dependecy('azyn_use_submenu_link_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_submenu_link_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_submenu_link_typo', 'azyn_use_submenu_link_typo', 'true');
	$shortcode->add_dependecy('azyn_use_mega_menu_title_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_mega_menu_title_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_mega_menu_title_typo', 'azyn_use_mega_menu_title_typo', 'true');
	$shortcode->add_dependecy('azyn_use_desk_menu_link_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_desk_menu_link_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_desk_menu_link_typo', 'azyn_use_desk_menu_link_typo', 'true');
	$shortcode->add_dependecy('azyn_desk_menu', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_use_logo_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_use_logo_typo', 'type_logo', 'text');
	$shortcode->add_dependecy('azyn_logo_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_logo_typo', 'azyn_use_logo_typo', 'true');
	$shortcode->add_dependecy('azyn_menu_right', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_second_menu', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_logo_desk_image', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_desk_add_image', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_networks_title', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_networks', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_max_width_mega', 'template', 'azyn_layout1');


	aheto_demos_add_dependency(['max_width','mob_logo','add_scroll_logo','scroll_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'transparent', 'type_logo', 'logo', 'text_logo', 'mobile_menu_width', 'mob_menu_title_typo', 'use_mob_menu_title_typo'], ['azyn_layout1'], $shortcode);


	$shortcode->add_params([
		'azyn_max_width_mega'          => [
			'type'      => 'slider',
			'heading'   => esc_html__('Max width for megamenu', 'azyn'),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .main-header--desktop .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		],
		'azyn_logo_desk_image'    => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Image logo for additional menu', 'aheto' ),
		],
		'azyn_desk_add_image'    => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Main image for additional menu', 'aheto' ),
		],
		'azyn_desk_menu' => [
			'type'    => 'select',
			'heading' => esc_html__('Additional menu', 'aheto'),
			'options' => Helper::choices_nav_menu(),
		],
		'azyn_networks_title'          => [
			'type'    => 'text',
			'heading' => esc_html__( 'Title for networks', 'aheto' ),
		],
		'azyn_networks' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Networks', 'aheto' ),
			'params'  => [
				'network' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Network', 'aheto' ),
					'options' => Helper::choices_social_network(),
				],
				'url'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Url', 'aheto' ),
				],
			],
		],
		'azyn_use_desk_menu_link_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for additional menu links?', 'aheto'),
			'grid'    => 3,
		],
		'azyn_desk_menu_link_typo'      => [
			'type'     => 'typography',
			'group'    => 'Additional menu links Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .desk-menu__container .menu-item a',
		],
		'azyn_use_menu_link_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu links?', 'aheto'),
			'grid'    => 3,
		],
		'azyn_menu_link_typo'           => [
			'type'     => 'typography',
			'group'    => 'Menu links Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-home-page-container .menu-item a',
		],
		'azyn_use_submenu_link_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for submenu links?', 'aheto'),
			'grid'    => 3,
		],
		'azyn_submenu_link_typo'        => [
			'type'     => 'typography',
			'group'    => 'Submenu links Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-home-page-container .menu-item .sub-menu a',
		],
		'azyn_use_logo_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for logo?', 'aheto'),
			'grid'    => 3,
		],
		'azyn_logo_typo'                => [
			'type'     => 'typography',
			'group'    => 'Logo Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__logo span',
		],
		'azyn_use_mega_menu_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for mega menu title?', 'aheto'),
			'grid'    => 3,
		],
		'azyn_mega_menu_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Mega Menu Title Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .mega-menu__title',
		],
		'azyn_menu_right'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Align menu to the right side?', 'aheto'),
			'grid'    => 3,
		],
		'azyn_second_menu'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Hide additional menu?', 'aheto'),
			'grid'    => 3,
		],

	]);

}

function azyn_navigation_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['azyn_use_desk_menu_link_typo']) && $shortcode->atts['azyn_use_desk_menu_link_typo'] && isset($shortcode->atts['azyn_desk_menu_link_typo']) && !empty($shortcode->atts['azyn_desk_menu_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .desk-menu__container .menu-item a'], $shortcode->parse_typography($shortcode->atts['azyn_desk_menu_link_typo']));
	}
	if ( isset($shortcode->atts['azyn_use_menu_link_typo']) && $shortcode->atts['azyn_use_menu_link_typo'] && isset($shortcode->atts['azyn_menu_link_typo']) && !empty($shortcode->atts['azyn_menu_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .menu-home-page-container .menu-item a'], $shortcode->parse_typography($shortcode->atts['azyn_menu_link_typo']));
	}
	if ( isset($shortcode->atts['azyn_use_submenu_link_typo']) && $shortcode->atts['azyn_use_submenu_link_typo'] && isset($shortcode->atts['azyn_submenu_link_typo']) && !empty($shortcode->atts['azyn_submenu_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .menu-home-page-container .menu-item .sub-menu a'], $shortcode->parse_typography($shortcode->atts['azyn_submenu_link_typo']));
	}
	if ( isset($shortcode->atts['azyn_use_logo_typo']) && $shortcode->atts['azyn_use_logo_typo'] && isset($shortcode->atts['azyn_logo_typo']) && !empty($shortcode->atts['azyn_logo_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography($shortcode->atts['azyn_logo_typo']));
	}
	if ( isset($shortcode->atts['azyn_use_mega_menu_title_typo']) && $shortcode->atts['azyn_use_mega_menu_title_typo'] && isset($shortcode->atts['azyn_mega_menu_title_typo'])  && !empty($shortcode->atts['azyn_mega_menu_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .mega-menu__title'], $shortcode->parse_typography($shortcode->atts['azyn_mega_menu_title_typo']));
	}
	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'azyn_navigation_layout1_dynamic_css', 10, 2);
