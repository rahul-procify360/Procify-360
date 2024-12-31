<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-slider_register', 'karma_travel_features_slider_layout2');


function karma_travel_features_slider_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/features-slider/previews/';

	$shortcode->add_layout('karma_travel_layout2', [
		'title' => esc_html__('Karma Travel Layout 2', 'karma'),
		'image' => $preview_dir . 'karma_travel_layout2.jpg',
	]);
	aheto_demos_add_dependency(['t_heading', 'use_heading'], ['karma_travel_layout2'], $shortcode);
	$shortcode->add_dependecy('karma_travel_slider2', 'template', 'karma_travel_layout2');

	$shortcode->add_dependecy('karma_travel_use_desc_typo', 'template', ['karma_travel_layout2']);
	$shortcode->add_dependecy('karma_travel_desc_typo', 'template', 'karma_travel_layout2');
	$shortcode->add_dependecy('karma_travel_desc_typo', 'karma_travel_use_desc_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_icon_txt_typo', 'template', ['karma_travel_layout2']);
	$shortcode->add_dependecy('karma_travel_icon_txt_typo', 'template', 'karma_travel_layout2');
	$shortcode->add_dependecy('karma_travel_icon_txt_typo', 'karma_travel_use_icon_txt_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_star_typo', 'template', ['karma_travel_layout2']);
	$shortcode->add_dependecy('karma_travel_star_typo', 'template', 'karma_travel_layout2');
	$shortcode->add_dependecy('karma_travel_star_typo', 'karma_travel_use_star_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_rating_typo', 'template', ['karma_travel_layout2']);
	$shortcode->add_dependecy('karma_travel_rating_typo', 'template', 'karma_travel_layout2');
	$shortcode->add_dependecy('karma_travel_rating_typo', 'karma_travel_use_rating_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_icon_typo', 'template', ['karma_travel_layout2']);
	$shortcode->add_dependecy('karma_travel_icon_typo', 'template', 'karma_travel_layout2');
	$shortcode->add_dependecy('karma_travel_icon_typo', 'karma_travel_use_icon_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_price_typo', 'template', ['karma_travel_layout2']);
	$shortcode->add_dependecy('karma_travel_price_typo', 'template', 'karma_travel_layout2');
	$shortcode->add_dependecy('karma_travel_price_typo', 'karma_travel_use_price_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_price_text_typo', 'template', ['karma_travel_layout2']);
	$shortcode->add_dependecy('karma_travel_price_text_typo', 'template', 'karma_travel_layout2');
	$shortcode->add_dependecy('karma_travel_price_text_typo', 'karma_travel_use_price_text_typo', 'true');

	$shortcode->add_params([
		'karma_travel_slider2' => [
			'type'    => 'group',
			'heading' => esc_html__('Items Slider', 'karma'),
			'params'  => [
				'karma_travel_image'    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
				'karma_travel_heading'  => [
					'type'    => 'text',
					'heading' => esc_html__('Heading', 'karma'),
				],
				'karma_travel_hide_rating'         => [
					'type'    => 'switch',
					'heading' => esc_html__('Hide rating stars?', 'karma'),
					'grid'    => 3,
				],
				'karma_travel_rating'      => [
					'type'    => 'select',
					'heading' => esc_html__('Rating', 'karma'),
					'options' => [
						'1'   => esc_html__('1', 'karma'),
						'1.5' => esc_html__('1.5', 'karma'),
						'2'   => esc_html__('2', 'karma'),
						'2.5' => esc_html__('2.5', 'karma'),
						'3'   => esc_html__('3', 'karma'),
						'3.5' => esc_html__('3.5', 'karma'),
						'4'   => esc_html__('4', 'karma'),
						'4.5' => esc_html__('4.5', 'karma'),
						'5'   => esc_html__('5', 'karma'),
					],
					'default' => '5',
				],
				'karma_travel_rating_text'  => [
					'type'    => 'text',
					'heading' => esc_html__('Rating Text', 'karma'),
				],
				'karma_travel_desc' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'karma'),
				],
				'karma_travel_days' => [
					'type'    => 'text',
					'heading' => esc_html__('Days', 'karma'),
				],
				'karma_travel_cat' => [
					'type'    => 'text',
					'heading' => esc_html__('Category', 'karma'),
				],
				'karma_travel_age' => [
					'type'    => 'text',
					'heading' => esc_html__('Age', 'karma'),
				],
				'karma_travel_price' => [
					'type'    => 'text',
					'heading' => esc_html__('Price', 'karma'),
				],
				'karma_travel_price_label' => [
					'type'    => 'text',
					'heading' => esc_html__('Price Label', 'karma'),
				],
				'karma_travel_price_before' => [
					'type'    => 'text',
					'heading' => esc_html__('Before Price', 'karma'),
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
		'karma_travel_use_icon_txt_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for labels?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_icon_txt_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Labels Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__labels',
		],
		'karma_travel_use_star_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for star?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_star_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Star Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__stars i',
		],
		'karma_travel_use_rating_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for rating?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_rating_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Rating Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__rating-text',
		],
		'karma_travel_use_icon_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for icon?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_icon_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Icon Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__labels i',
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
		'karma_travel_use_price_text_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price text?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_price_text_typo'             => [
			'type'     => 'typography',
			'group'    => 'Karma Price Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-slider__price-label',
		],

	]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'prefix'         => 'karma_travel_',
		'group'          => 'Karma Travel Swiper',
		'custom_options' => true,
		'include'        => ['pagination', 'delay', 'speed', 'loop', 'slides', 'spaces', 'small', 'medium', 'large', 'simulate_touch'],
		'dependency'     => ['template', ['karma_travel_layout2']]
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'add_button' => true,
		'prefix' => 'karma_travel_main_',
	], 'karma_travel_slider2');
	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon' => true,
		'exclude'  => ['align'],
	], 'karma_travel_slider2');
}


function karma_travel_features_slider_layout2_dynamic_css($css, $shortcode){

	if ( isset($shortcode->atts['karma_travel_use_desc_typo']) && $shortcode->atts['karma_travel_use_desc_typo'] && isset($shortcode->atts['karma_travel_desc_typo']) && !empty($shortcode->atts['karma_travel_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-features-slider__desc'], $shortcode->parse_typography($shortcode->atts['karma_travel_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_icon_txt_typo']) && $shortcode->atts['karma_travel_use_icon_txt_typo'] && isset($shortcode->atts['karma_travel_icon_txt_typo']) && !empty($shortcode->atts['karma_travel_icon_txt_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-features-slider__labels'], $shortcode->parse_typography($shortcode->atts['karma_travel_icon_txt_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_star_typo']) && $shortcode->atts['karma_travel_use_star_typo'] && isset($shortcode->atts['karma_travel_star_typo']) && !empty($shortcode->atts['karma_travel_star_typo']) ) {
		\aheto_add_props($css['global']['%1$s   .aheto-features-slider__stars i'], $shortcode->parse_typography($shortcode->atts['karma_travel_star_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_rating_typo']) && $shortcode->atts['karma_travel_use_rating_typo'] && isset($shortcode->atts['karma_travel_rating_typo']) && !empty($shortcode->atts['karma_travel_rating_typo']) ) {
		\aheto_add_props($css['global']['%1$s   .aheto-features-slider__rating-text'], $shortcode->parse_typography($shortcode->atts['karma_travel_rating_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_icon_typo']) && $shortcode->atts['karma_travel_use_icon_typo'] && isset($shortcode->atts['karma_travel_icon_typo']) && !empty($shortcode->atts['karma_travel_icon_typo']) ) {
		\aheto_add_props($css['global']['%1$s   .aheto-features-slider__labels i'], $shortcode->parse_typography($shortcode->atts['karma_travel_icon_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_price_typo']) && $shortcode->atts['karma_travel_use_price_typo'] && isset($shortcode->atts['karma_travel_price_typo']) && !empty($shortcode->atts['karma_travel_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s   .aheto-features-slider__price'], $shortcode->parse_typography($shortcode->atts['karma_travel_price_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_price_text_typo']) && $shortcode->atts['karma_travel_use_price_text_typo'] && isset($shortcode->atts['karma_travel_price_text_typo']) && !empty($shortcode->atts['karma_travel_price_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s   .aheto-features-slider__price-label'], $shortcode->parse_typography($shortcode->atts['karma_travel_price_text_typo']));
	}

	return $css;
}

add_filter('aheto_features_slider_dynamic_css', 'karma_travel_features_slider_layout2_dynamic_css', 10, 2);