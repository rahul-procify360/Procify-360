<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-slider_register', 'karma_education_features_slider_layout1');


function karma_education_features_slider_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout('karma_education_layout1', [
		'title' => esc_html__('Features Slider 5', 'karma'),
		'image' => $preview_dir . 'karma_education_layout1.jpg',
	]);

	aheto_demos_add_dependency(['t_heading', 'use_heading', 't_description', 'use_description'], ['karma_education_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_education_slider', 'template', 'karma_education_layout1');

	$shortcode->add_dependecy('karma_education_use_time_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_time_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_time_typo', 'karma_education_use_time_typo', 'true');

	$shortcode->add_dependecy('karma_education_use_num_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_num_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_num_typo', 'karma_education_use_num_typo', 'true');

	$shortcode->add_params([

		'karma_education_slider'        => [
			'type'    => 'group',
			'heading' => esc_html__('Features Slider', 'karma'),
			'params'  => [
				'karma_education_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
				'karma_education_number'      => [
					'type'    => 'text',
					'heading' => esc_html__('Number', 'karma'),
				],
				'karma_education_heading'     => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'karma'),
				],
				'karma_education_date' => [
					'type'    => 'text',
					'heading' => esc_html__('Date', 'karma'),
				],
				'karma_education_time'  => [
					'type'    => 'text',
					'heading' => esc_html__('Time', 'karma'),
				],
				'karma_education_place'    => [
					'type'    => 'text',
					'heading' => esc_html__('Place', 'karma'),
				],
			],
		],

		'karma_education_use_time_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for time text?', 'karma'),
		],
		'karma_education_time_typo'     => [
			'type'     => 'typography',
			'group'    => 'Time Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__info-text-bottom',
		],

		'karma_education_use_num_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for number text?', 'karma'),
		],
		'karma_education_num_typo'      => [
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
		'prefix'         => 'karma_education_',
		'custom_options' => true,
		'group'          => 'Karma Swiper',
		'include'        => ['pagination', 'delay', 'speed', 'loop', 'slides', 'spaces', 'small', 'medium', 'large', 'simulate_touch'],
		'dependency'     => ['template', ['karma_education_layout1']]
	]);
}

function karma_education_features_slider_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_education_use_time_typo']) && !empty($shortcode->atts['karma_education_time_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-slider__info-text-bottom'], $shortcode->parse_typography($shortcode->atts['karma_education_time_typo']));
	}

	if ( !empty($shortcode->atts['karma_education_use_num_typo']) && !empty($shortcode->atts['karma_education_num_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-features-slider__number'], $shortcode->parse_typography($shortcode->atts['karma_education_num_typo']));
	}

	return $css;

}

add_filter('karma_features_slider_dynamic_css', 'karma_education_features_slider_layout1_dynamic_css', 10, 2);
