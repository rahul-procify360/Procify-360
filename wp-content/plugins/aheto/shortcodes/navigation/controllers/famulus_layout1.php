<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'famulus_navigation_layout1');


/**
 * Navbar
 */

function famulus_navigation_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Navigation 6', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	aheto_demos_add_dependency(['type_logo', 'text_logo', 'logo', 'add_scroll_logo', 'scroll_logo', 'transparent', 'mob_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'mobile_menu_width', 'use_mob_menu_title_typo', 'mob_menu_title_typo'], ['famulus_layout1'], $shortcode);

	$shortcode->add_dependecy('famulus_mob_menu_title', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_logo_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_logo_use_typo', 'type_logo', 'text');
	$shortcode->add_dependecy('famulus_logo_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_logo_typo', 'famulus_logo_use_typo', 'true');
	$shortcode->add_dependecy('famulus_link_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_link_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_link_typo', 'famulus_link_use_typo', 'true');
	$shortcode->add_dependecy('famulus_progressbar', 'template', 'famulus_layout1');

	$shortcode->add_params([
		'famulus_progressbar' => [
			'type'    => 'switch',
			'heading' => esc_html__('Add progressbar?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_logo_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for logo text?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_logo_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Logo Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__logo span',
		],
		'famulus_link_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header--classic ul li a',
		],
        'famulus_mob_menu_title'        => [
            'type'    => 'text',
            'heading' => esc_html__( 'Type Mobile menu title', 'famulus' ),
            'default' => esc_html__( 'Menu', 'famulus' ),
        ],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix'     => 'famulus_main_',
		'group'      => 'Desktop buttons',
		'icons'      => true,
		'dependency' => ['template', ['famulus_layout1']]
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'add_label'  => esc_html__('Add additional button?', 'famulus'),
		'prefix'     => 'famulus_add_',
		'group'      => 'Desktop buttons',
		'icons'      => true,
		'dependency' => ['template', ['famulus_layout1']]
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix'     => 'famulus_main_mob_',
		'group'      => 'Mobile Buttons',
		'icons'      => true,
		'dependency' => ['template', ['famulus_layout1']]
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'add_label'  => esc_html__('Add additional button?', 'famulus'),
		'prefix'     => 'famulus_add_mob_',
		'group'      => 'Mobile Buttons',
		'icons'      => true,
		'dependency' => ['template', ['famulus_layout1']]
	]);

}
function famulus_aheto_navigation_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_logo_use_typo']) && $shortcode->atts['famulus_logo_use_typo'] && isset($shortcode->atts['famulus_logo_typo']) && !empty($shortcode->atts['famulus_logo_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography($shortcode->atts['famulus_logo_typo']));
	}	
	if ( isset($shortcode->atts['famulus_link_use_typo']) && $shortcode->atts['famulus_link_use_typo'] && isset($shortcode->atts['famulus_link_typo']) && !empty($shortcode->atts['famulus_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header--classic ul li a'], $shortcode->parse_typography($shortcode->atts['famulus_link_typo']));
	}


	return $css;
}
add_filter('aheto_navigation_dynamic_css', 'famulus_aheto_navigation_layout1_dynamic_css', 10, 2);
