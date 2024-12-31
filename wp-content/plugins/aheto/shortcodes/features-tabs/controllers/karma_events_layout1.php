<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-tabs_register', 'karma_events_features_tabs_layout1');


/**
 * Pricing Tables Shortcode
 */

function karma_events_features_tabs_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/features-tabs/previews/';

	$shortcode->add_layout('karma_events_layout1', [
		'title' => esc_html__('Features Tabs 5', 'karma'),
		'image' => $preview_dir . 'karma_events_layout1.jpg',
	]);
	$shortcode->add_dependecy('karma_events_main_title', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_pricings', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_use_heading_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_heading_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_heading_typo', 'karma_events_use_heading_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_main_title_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_main_title_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_main_title_typo', 'karma_events_use_main_title_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_heading_top_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_heading_top_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_heading_top_typo', 'karma_events_use_heading_top_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_desc_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_desc_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_desc_typo', 'karma_events_use_desc_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_link_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_link_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_typo', 'karma_events_use_link_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_link_day_typo', 'template', ['karma_events_layout1']);
	$shortcode->add_dependecy('karma_events_link_day_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_day_typo', 'karma_events_use_link_day_typo', 'true');

	$shortcode->add_params([
		'karma_events_main_title'   => [
			'type'    => 'text',
			'heading' => esc_html__('Main Title', 'karma'),
			'default' => esc_html__('Put your text...', 'karma'),
		],
		'karma_events_use_heading_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for session?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_heading_typo'           => [
			'type'     => 'typography',
			'group'    => 'Karma Events session Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tabs__box-inner h5',
		],
		'karma_events_use_main_title_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for main title?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_main_title_typo'           => [
			'type'     => 'typography',
			'group'    => 'Karma Events Main Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tabs__box-main-title',
		],
		'karma_events_use_heading_top_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading top?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_heading_top_typo'           => [
			'type'     => 'typography',
			'group'    => 'Karma Events Heading Top Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tabs__box-top p',
		],
		'karma_events_use_desc_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_desc_typo'              => [
			'type'     => 'typography',
			'group'    => 'Karma Events Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tabs__box-inner p',
		],
		'karma_events_use_link_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_link_typo'              => [
			'type'     => 'typography',
			'group'    => 'Karma Events Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tabs__list-link',
		],
		'karma_events_use_link_day_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links day?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_link_day_typo'              => [
			'type'     => 'typography',
			'group'    => 'Karma Events Links Day Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tabs__list-link span',
		],
		//Isotope
		'karma_events_pricings'               => [
			'type'    => 'group',
			'heading' => esc_html__('Karma Events Consult Pricing Items', 'karma'),
			'params'  => [
				'karma_events_pricings_heading' => [
					'type'    => 'text',
					'heading' => esc_html__('Category', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],
				'karma_events_pricings_title'   => [
					'type'    => 'text',
					'heading' => esc_html__('Category session', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],

				'karma_events_pricings_label'   => [
					'type'    => 'text',
					'heading' => esc_html__('Category speaker(s)', 'karma'),
					'default' => esc_html__('', 'karma_events'),
				],
				'karma_events_pricings_price'   => [
					'type'    => 'text',
					'heading' => esc_html__('Category time', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],
				'karma_events_pricings_descr'   => [
					'type'    => 'textarea',
					'heading' => esc_html__('Category venue', 'karma'),
					'default' => esc_html__('Put your text...', 'karma'),
				],
			],
		],
		//Isotope
	]);
}

function karma_events_features_tabs_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_events_use_heading_typo']) && $shortcode->atts['karma_events_use_heading_typo'] && isset($shortcode->atts['karma_events_heading_typo']) && !empty($shortcode->atts['karma_events_heading_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tabs__box-inner h5'], $shortcode->parse_typography($shortcode->atts['karma_events_heading_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_main_title_typo']) && $shortcode->atts['karma_events_use_main_title_typo'] && isset($shortcode->atts['karma_events_main_title_typo']) && !empty($shortcode->atts['karma_events_main_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tabs__box-main-title'], $shortcode->parse_typography($shortcode->atts['karma_events_main_title_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_heading_top_typo']) && $shortcode->atts['karma_events_use_heading_top_typo'] && isset($shortcode->atts['karma_events_heading_top_typo']) && !empty($shortcode->atts['karma_events_heading_top_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tabs__box-top p'], $shortcode->parse_typography($shortcode->atts['karma_events_heading_top_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_desc_typo']) && $shortcode->atts['karma_events_use_desc_typo'] && isset($shortcode->atts['karma_events_desc_typo']) && !empty($shortcode->atts['karma_events_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tabs__box-inner p'], $shortcode->parse_typography($shortcode->atts['karma_events_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_link_typo']) && $shortcode->atts['karma_events_use_link_typo'] && isset($shortcode->atts['karma_events_link_typo']) && !empty($shortcode->atts['karma_events_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tabs__list-link'], $shortcode->parse_typography($shortcode->atts['karma_events_link_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_link_day_typo']) && $shortcode->atts['karma_events_use_link_day_typo'] && isset($shortcode->atts['karma_events_link_day_typo']) && !empty($shortcode->atts['karma_events_link_day_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tabs__list-link span'], $shortcode->parse_typography($shortcode->atts['karma_events_link_day_typo']));
	}
	return $css;
}

add_filter('aheto_features_tabs_dynamic_css', 'karma_events_features_tabs_layout1_dynamic_css', 10, 2);

