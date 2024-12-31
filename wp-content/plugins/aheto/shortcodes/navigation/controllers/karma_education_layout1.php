<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'karma_education_navigation_layout1');


/**
 * Navigation Shortcode
 */

function karma_education_navigation_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('karma_education_layout1', [
		'title' => esc_html__('Navigation 12', 'karma'),
		'image' => $preview_dir . 'karma_education_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_education_use_menu_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_menu_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_menu_typo', 'karma_education_use_menu_typo', 'true');

	$shortcode->add_dependecy('karma_education_title_use_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_title_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_title_typo', 'karma_education_title_use_typo', 'true');

	$shortcode->add_dependecy('karma_education_contact_use_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_contact_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_contact_typo', 'karma_education_contact_use_typo', 'true');

	$shortcode->add_dependecy('karma_education_icon_use_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_icon_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_icon_typo', 'karma_education_icon_use_typo', 'true');

	$shortcode->add_dependecy('karma_education_phone_title', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_address_title', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_phone', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_address', 'template', 'karma_education_layout1');

	$shortcode->add_dependecy('networks', 'template', 'karma_education_layout1');

	aheto_demos_add_dependency( [ 'list_space', 'type_logo', 'text_logo', 'logo', 'mob_logo', 'search', 'mobile_menu_width', 'mob_menu_title_typo', 'use_mob_menu_title_typo' ], ['karma_education_layout1'], $shortcode);

	$shortcode->add_params([

		'karma_education_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu text?', 'karma'),
			'grid'    => 3,
		],
		'karma_education_menu_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Education Menu Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} ul.main-menu > li > a, ul.sub-menu > li > a',
		],
		'networks' => true,

	]);

	\Aheto\Params::add_networks_params($shortcode, [
		'prefix'     => 'karma_education_',
        'dependency' => ['template', ['karma_education_layout1']]
	]);

}

function karma_education_navigation_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_education_use_menu_typo']) && !empty($shortcode->atts['karma_education_menu_typo']) ) {
		\aheto_add_props($css['global']['%1$s ul.main-menu > li > a, ul.sub-menu > li > a'], $shortcode->parse_typography($shortcode->atts['karma_education_menu_typo']));
	}

	if ( !empty($shortcode->atts['karma_education_title_use_typo']) && !empty($shortcode->atts['karma_education_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__details-title'], $shortcode->parse_typography($shortcode->atts['karma_education_title_typo']));
	}

	if ( !empty($shortcode->atts['karma_education_contact_use_typo']) && !empty($shortcode->atts['karma_education_contact_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .main-header__details-text a, %1$s .main-header__details-text p'], $shortcode->parse_typography($shortcode->atts['karma_education_contact_typo']));
	}

	if ( !empty($shortcode->atts['karma_education_icon_use_typo']) && !empty($shortcode->atts['karma_education_icon_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .icons-widget__link i'], $shortcode->parse_typography($shortcode->atts['karma_education_icon_typo']));
	}

	return $css;

}

add_filter('aheto_navigation_dynamic_css', 'karma_education_navigation_layout1_dynamic_css', 10, 2);