<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-slider_register', 'karma_travel_features_slider_layout3');


function karma_travel_features_slider_layout3($shortcode) {

	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout('karma_travel_layout3', [
		'title' => esc_html__('Karma Travel Layout 3', 'karma'),
		'image' => $preview_dir . 'karma_travel_layout3.jpg',
	]);
	aheto_demos_add_dependency(['t_heading', 'use_heading'], ['karma_travel_layout3'], $shortcode);
	$shortcode->add_dependecy('karma_travel_slider', 'template', 'karma_travel_layout3');

	$shortcode->add_dependecy('karma_travel_use_desc_typo', 'template', ['karma_travel_layout3']);
	$shortcode->add_dependecy('karma_travel_desc_typo', 'template', 'karma_travel_layout3');
	$shortcode->add_dependecy('karma_travel_desc_typo', 'karma_travel_use_desc_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_label_typo', 'template', ['karma_travel_layout3']);
	$shortcode->add_dependecy('karma_travel_label_typo', 'template', 'karma_travel_layout3');
	$shortcode->add_dependecy('karma_travel_label_typo', 'karma_travel_use_label_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_price_typo', 'template', ['karma_travel_layout3']);
	$shortcode->add_dependecy('karma_travel_price_typo', 'template', 'karma_travel_layout3');
	$shortcode->add_dependecy('karma_travel_price_typo', 'karma_travel_use_price_typo', 'true');

	$shortcode->add_params([
		'karma_travel_slider' => [
			'type'    => 'group',
			'heading' => esc_html__('Feature Slider', 'karma'),
			'params'  => [
				'karma_travel_image'    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
				'karma_travel_link'  => [
					'type'    => 'text',
					'heading' => esc_html__('Link', 'karma'),
				],
				'karma_travel_heading'  => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'karma'),
				],
				'karma_travel_price'  => [
					'type'    => 'text',
					'heading' => esc_html__('Price', 'karma'),
				],
				'karma_travel_label'  => [
					'type'    => 'text',
					'heading' => esc_html__('Label', 'karma'),
				],
				'karma_travel_desc' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'karma'),
				],
				'karma_travel_label_color1' => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Label background color 1', 'karma' ),
					'default'   => '#eeeeee',
				],
				'karma_travel_label_color2' => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Label background color 2', 'karma' ),
					'default'   => '#eeeeee',
				],
			],
		],
		'karma_travel_use_desc_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for description?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_desc_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__desc',
		],
		'karma_travel_use_label_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for label?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_label_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__label',
		],
		'karma_travel_use_price_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_price_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__price',
		],

	]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'prefix'         => 'karma_travel_',
		'group'          => 'Karma Travel Swiper',
		'custom_options' => true,
		'include'        => ['arrows', 'delay', 'speed', 'loop', 'slides', 'spaces', 'small', 'medium', 'large', 'simulate_touch', 'arrows_color', 'arrows_size'],
		'dependency'     => ['template', ['karma_travel_layout3']]
	]);
}


function karma_travel_features_slider_layout3_dynamic_css($css, $shortcode){

	if ( isset($shortcode->atts['karma_travel_use_desc_typo']) && $shortcode->atts['karma_travel_use_desc_typo'] && isset($shortcode->atts['karma_travel_desc_typo']) && !empty($shortcode->atts['karma_travel_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-features-slider__desc'], $shortcode->parse_typography($shortcode->atts['karma_travel_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_label_typo']) && $shortcode->atts['karma_travel_use_label_typo'] && isset($shortcode->atts['karma_travel_label_typo']) && !empty($shortcode->atts['karma_travel_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-features-slider__label'], $shortcode->parse_typography($shortcode->atts['karma_travel_label_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_price_typo']) && $shortcode->atts['karma_travel_use_price_typo'] && isset($shortcode->atts['karma_travel_price_typo']) && !empty($shortcode->atts['karma_travel_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-features-slider__price'], $shortcode->parse_typography($shortcode->atts['karma_travel_price_typo']));
	}

	return $css;
}

add_filter('aheto_features_slider_dynamic_css', 'karma_travel_features_slider_layout3_dynamic_css', 10, 2);