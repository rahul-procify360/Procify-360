<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-slider_register', 'karma_construction_features_slider_layout1');


function karma_construction_features_slider_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout('karma_construction_layout1', [
		'title' => esc_html__('Features Slider 4', 'karma'),
		'image' => $preview_dir . 'karma_construction_layout1.jpg',
	]);
	aheto_demos_add_dependency(['t_heading', 'use_heading', 't_description', 'use_description'], ['karma_construction_layout1'], $shortcode);
	$shortcode->add_dependecy('karma_construction_slider', 'template', 'karma_construction_layout1');

	$shortcode->add_dependecy('karma_construction_use_link_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_link_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_link_typo', 'karma_construction_use_link_typo', 'true');

	$shortcode->add_dependecy('karma_construction_use_num_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_num_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_num_typo', 'karma_construction_use_num_typo', 'true');

	$shortcode->add_params([
		'karma_construction_slider'        => [
			'type'    => 'group',
			'heading' => esc_html__('Features Slider', 'karma'),
			'params'  => [
				'karma_construction_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
				'karma_construction_number'      => [
					'type'    => 'text',
					'heading' => esc_html__('Number', 'karma'),
				],
				'karma_construction_heading'     => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'karma'),
				],
				'karma_construction_description' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'karma'),
				],
				'karma_construction_link_title'  => [
					'type'    => 'text',
					'heading' => esc_html__('Link Title', 'karma'),
				],
				'karma_construction_link_url'    => [
					'type'    => 'text',
					'heading' => esc_html__('Link URL', 'karma'),
				],
			],
		],
		'karma_construction_use_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link text?', 'karma'),
		],
		'karma_construction_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__info-link',
		],
		'karma_construction_use_num_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for number text?', 'karma'),
		],
		'karma_construction_num_typo'      => [
			'type'     => 'typography',
			'group'    => 'Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__number',
		],
	]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'prefix'         => 'karma_construction_',
		'group'          => 'Karma Construction Swiper',
		'custom_options' => true,
		'include'        => ['arrows', 'delay', 'speed', 'loop', 'slides', 'spaces', 'small', 'medium', 'large', 'simulate_touch', 'arrows_color', 'arrows_size'],
		'dependency'     => ['template', ['karma_construction_layout1']]
	]);
}

function karma_construction_features_slider_layout1_dynamic_css($css, $shortcode) {
	if ( !empty($shortcode->atts['karma_construction_use_link_typo']) && !empty($shortcode->atts['karma_construction_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-slider__info-link'], $shortcode->parse_typography($shortcode->atts['karma_construction_link_typo']));
	}
	if ( !empty($shortcode->atts['karma_construction_use_num_typo']) && !empty($shortcode->atts['karma_construction_num_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-slider__number'], $shortcode->parse_typography($shortcode->atts['karma_construction_num_typo']));
	}

	return $css;
}

add_filter('karma_features_slider_dynamic_css', 'karma_construction_features_slider_layout1_dynamic_css', 10, 2);
