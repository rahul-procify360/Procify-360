<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'famulus_navbar_layout3');


/**
 * Navbar
 */

function famulus_navbar_layout3($shortcode) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout('famulus_layout3', [
		'title' => esc_html__('Navbar 4', 'famulus'),
		'image' => $preview_dir . 'famulus_layout3.jpg',
	]);

	$shortcode->add_dependecy('famulus_links', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_title', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_title_tag', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_link_title_main', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_link_url_main', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_title_use_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_title_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_title_typo', 'famulus_title_use_typo', 'true');
	$shortcode->add_dependecy('famulus_highlight_use_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_highlight_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_highlight_typo', 'famulus_highlight_use_typo', 'true');
	$shortcode->add_dependecy('famulus_links_all_use_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_links_all_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_links_all_typo', 'famulus_links_all_use_typo', 'true');
	$shortcode->add_dependecy('famulus_link_main_use_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_link_main_typo', 'template', 'famulus_layout3');
	$shortcode->add_dependecy('famulus_link_main_typo', 'famulus_link_main_use_typo', 'true');

	$shortcode->add_params([

		'famulus_title'           => [
			'type'    => 'text',
			'heading' => esc_html__('Menu Title', 'famulus'),
		],
		'famulus_title_tag'       => [
			'type'    => 'select',
			'heading' => esc_html__('Title tag', 'famulus'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h4',
			'grid'    => 2,
		],
		'famulus_links'           => [
			'type'    => 'group',
			'heading' => esc_html__('Links', 'famulus'),
			'params'  => [
				'famulus_link_title' => [
					'type'    => 'text',
					'heading' => esc_html__('Link Title', 'famulus'),
				],
				'famulus_link_url'   => [
					'type'    => 'text',
					'heading' => esc_html__('Link Url', 'famulus'),
					'default' => esc_html__('#', 'famulus'),
				],
			]
		],
		'famulus_link_title_main' => [
			'type'    => 'text',
			'heading' => esc_html__('Main Link Title', 'famulus'),
		],
		'famulus_link_url_main'   => [
			'type'    => 'text',
			'heading' => esc_html__('Main Link Url', 'famulus'),
			'default' => esc_html__('#', 'famulus'),
		],
		'famulus_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar__title',
		],
		'famulus_highlight_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for highlight?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_highlight_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Highlight Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar__title span',
		],

		'famulus_links_all_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_links_all_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar__links',
		],

		'famulus_link_main_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for main link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_main_typo'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Main Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar__main-link',
		],
	]);
}

function famulus_navbar_layout3_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_title_use_typo']) && $shortcode->atts['famulus_title_use_typo'] && isset($shortcode->atts['famulus_title_typo']) && !empty($shortcode->atts['famulus_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-navbar__title'], $shortcode->parse_typography($shortcode->atts['famulus_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_highlight_use_typo']) && $shortcode->atts['famulus_highlight_use_typo'] && isset($shortcode->atts['famulus_highlight_typo']) && !empty($shortcode->atts['famulus_highlight_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-navbar__title span'], $shortcode->parse_typography($shortcode->atts['famulus_highlight_typo']));
	}
	if ( isset($shortcode->atts['famulus_links_all_use_typo']) && $shortcode->atts['famulus_links_all_use_typo'] && isset($shortcode->atts['famulus_links_all_typo']) && !empty($shortcode->atts['famulus_links_all_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-navbar__links'], $shortcode->parse_typography($shortcode->atts['famulus_links_all_typo']));
	}
	if ( isset($shortcode->atts['famulus_link_main_use_typo']) && $shortcode->atts['famulus_link_main_use_typo'] && isset($shortcode->atts['famulus_link_main_typo']) && !empty($shortcode->atts['famulus_link_main_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-navbar__main-link'], $shortcode->parse_typography($shortcode->atts['famulus_link_main_typo']));
	}
	return $css;
}

add_filter('aheto_navbar_dynamic_css', 'famulus_navbar_layout3_dynamic_css', 10, 2);