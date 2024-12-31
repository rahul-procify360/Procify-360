<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'karma_travel_features_single_layout1');


/**
 * Feature Single
 */

function karma_travel_features_single_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('karma_travel_layout1', [
		'title' => esc_html__('Karma Events Layout 1', 'karma'),
		'image' => $preview_dir . 'karma_travel_layout1.jpg',
	]);

	aheto_demos_add_dependency(['s_heading', 's_description'], ['karma_travel_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_travel_link_url', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_image', 'template', 'karma_travel_layout1');

	$shortcode->add_dependecy('karma_travel_title_use_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_title_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_title_typo', 'karma_travel_title_use_typo', 'true');

	$shortcode->add_dependecy('karma_travel_desc_use_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_desc_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_desc_typo', 'karma_travel_desc_use_typo', 'true');

	$shortcode->add_params([
		'karma_travel_image'                => [
			'type'        => 'attach_image',
			'heading'     => esc_html__('Image', 'karma'),
			'admin_label' => true,
		],
		'karma_travel_link_url'       => [
			'type'    => 'text',
			'heading' => esc_html__('Link URL', 'karma'),
		],
		'karma_travel_title_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Karma Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__title',
		],
		'karma_travel_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__info-text',
		],
	]);
	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon' => true,
		'exclude'  => ['align'],
		'dependency' => ['template', ['karma_travel_layout1']]
	]);
}

function karma_travel_features_single_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_travel_title_use_typo']) && $shortcode->atts['karma_travel_title_use_typo'] && isset($shortcode->atts['karma_travel_title_typo']) && !empty($shortcode->atts['karma_travel_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__title'], $shortcode->parse_typography($shortcode->atts['karma_travel_title_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_desc_use_typo']) && $shortcode->atts['karma_travel_desc_use_typo'] && isset($shortcode->atts['karma_travel_desc_typo']) && !empty($shortcode->atts['karma_travel_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__info-text'], $shortcode->parse_typography($shortcode->atts['karma_travel_desc_typo']));
	}

	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'karma_travel_features_single_layout1_dynamic_css', 10, 2);

