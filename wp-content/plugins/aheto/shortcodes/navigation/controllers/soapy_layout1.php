<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'soapy_navigation_layout1');


/**
 * Navbar
 */

function soapy_navigation_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Navigation 27', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['type_logo', 'logo', 'text_logo', 'add_scroll_logo', 'scroll_logo', 'search', 'mob_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'max_width', 'mini_cart', 'mobile_menu_width'], ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_cart_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_cart_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_cart_typo', 'soapy_cart_use_typo', 'true');
	$shortcode->add_dependecy('soapy_logo_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_logo_use_typo', 'type_logo', 'text');
	$shortcode->add_dependecy('soapy_logo_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_logo_typo', 'soapy_logo_use_typo', 'true');
	$shortcode->add_dependecy('soapy_links_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_links_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_links_typo', 'soapy_links_use_typo', 'true');
	$shortcode->add_dependecy('soapy_icon_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_icon_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_icon_typo', 'soapy_icon_use_typo', 'true');
	$shortcode->add_params([
		'soapy_cart_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for cart number?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_cart_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Cart Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .main-header__widget-box .button-number',
		],
		'soapy_logo_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for logo text?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_logo_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Logo Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__logo span',
		],
		'soapy_links_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_links_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header--classic-2 li a',
		],
		'soapy_icon_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for icons?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_icon_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Icons Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header--classic-2 li a.icons-widget__link',
		],
	]);
}
function soapy_navigation_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['soapy_cart_use_typo']) && $shortcode->atts['soapy_cart_use_typo'] && isset($shortcode->atts['soapy_cart_typo']) && !empty($shortcode->atts['soapy_cart_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__widget-box .button-number'], $shortcode->parse_typography($shortcode->atts['soapy_cart_typo']));
	}
	if ( isset($shortcode->atts['soapy_logo_use_typo']) && $shortcode->atts['soapy_logo_use_typo'] && isset($shortcode->atts['soapy_logo_typo']) && !empty($shortcode->atts['soapy_logo_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography($shortcode->atts['soapy_logo_typo']));
	}
	if ( isset($shortcode->atts['soapy_icon_use_typo']) && !empty($shortcode->atts['soapy_icon_use_typo']) && isset($shortcode->atts['soapy_icon_typo'])  && !empty($shortcode->atts['soapy_icon_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header--classic-2 li a.icons-widget__link'], $shortcode->parse_typography($shortcode->atts['soapy_icon_typo']));
	}
	if ( isset($shortcode->atts['soapy_links_use_typo']) && $shortcode->atts['soapy_links_use_typo'] && isset($shortcode->atts['soapy_links_typo']) && !empty($shortcode->atts['soapy_links_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header--classic-2 li a'], $shortcode->parse_typography($shortcode->atts['soapy_links_typo']));
	}
	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'soapy_navigation_layout1_dynamic_css', 10, 2);
