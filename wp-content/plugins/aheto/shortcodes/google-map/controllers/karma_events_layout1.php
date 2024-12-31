<?php

use Aheto\Helper;

add_action('aheto_before_aheto_google-map_register', 'karma_events_google_map_layout1');


/**
 * Feature Single
 */

function karma_events_google_map_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/google-map/previews/';

	$shortcode->add_layout('karma_events_layout1', [
		'title' => esc_html__('Google Map 1', 'karma'),
		'image' => $preview_dir . 'karma_events_layout1.jpg',
	]);

	aheto_demos_add_dependency(['height', 'overlay', 'addresses', 'zoom', 'item_marker', 'marker'], ['karma_events_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_events_titles', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_phone', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_address', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_email', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_hours', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_title_use_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_title_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_title_typo', 'karma_events_title_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_desc_use_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_desc_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_desc_typo', 'karma_events_desc_use_typo', 'true');

	$shortcode->add_params([
		'karma_events_titles'          => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'karma'),
		],
		'karma_events_phone'          => [
			'type'    => 'text',
			'heading' => esc_html__('Phone', 'karma'),
		],
		'karma_events_address'        => [
			'type'    => 'text',
			'heading' => esc_html__('Address', 'karma'),
		],
		'karma_events_email'          => [
			'type'    => 'text',
			'heading' => esc_html__('Email', 'karma'),
		],
		'karma_events_hours'          => [
			'type'    => 'text',
			'heading' => esc_html__('Hours', 'karma'),
		],
		'karma_events_title_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-map__title',
		],
		'karma_events_desc_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_desc_typo'      => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-map__desc',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix'     => 'karma_events_',
		'icons'      => true,
		'group'      => 'Karma Button',
		'dependency' => ['template', ['karma_events_layout1']]
	]);
}

function karma_events_google_map_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_events_title_use_typo']) && $shortcode->atts['karma_events_title_use_typo'] && isset($shortcode->atts['karma_events_title_typo']) && !empty($shortcode->atts['karma_events_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-map__title'], $shortcode->parse_typography($shortcode->atts['karma_events_title_typo']));
	}
	if ( isset($shortcode->atts['karma_events_desc_use_typo']) && $shortcode->atts['karma_events_desc_use_typo'] && isset($shortcode->atts['karma_events_desc_typo']) && !empty($shortcode->atts['karma_events_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-map__desc'], $shortcode->parse_typography($shortcode->atts['karma_events_desc_typo']));
	}

	return $css;
}

add_filter('aheto_google_map_dynamic_css', 'karma_events_google_map_layout1_dynamic_css', 10, 2);

