<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'karma_construction_testimonials_layout1');

/**
 * Testimonials
 */

function karma_construction_testimonials_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('karma_construction_layout1', [
		'title' => esc_html__('Testimonials 11', 'karma'),
		'image' => $preview_dir . 'karma_construction_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_construction_testimonials', 'template', ['karma_construction_layout1']);
	$shortcode->add_dependecy('karma_construction_use_quote_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_quote_typo', 'karma_construction_use_quote_typo', 'true');
	$shortcode->add_dependecy('karma_construction_name_use_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_name_typo', 'karma_construction_name_use_typo', 'true');
	$shortcode->add_dependecy('karma_construction_pos_use_typo', 'template', 'karma_construction_layout1');
	$shortcode->add_dependecy('karma_construction_pos_typo', 'karma_construction_pos_use_typo', 'true');

	$shortcode->add_params([
		'karma_construction_testimonials'   => [
			'type'    => 'group',
			'heading' => esc_html__('Modern Testimonials Items', 'karma'),
			'params'  => [
				'karma_construction_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'karma'),
				],
				'karma_construction_rating'      => [
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
				'karma_construction_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'karma'),
					'default' => esc_html__('Author name', 'karma'),
				],
				'karma_construction_company'     => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'karma'),
					'default' => esc_html__('Author position', 'karma'),
				],
				'karma_construction_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'karma'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'karma'),
				],
			],
		],
		'karma_construction_use_quote_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for karma testimonials?', 'karma'),
			'grid'    => 12,
			'default' => '',
		],
		'karma_construction_quote_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Testimonials Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__title-wrap:after',
		],
		'karma_construction_name_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for karma name?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_name_typo'      => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'karma_construction_pos_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for karma position?', 'karma'),
			'grid'    => 3,
		],
		'karma_construction_pos_typo'       => [
			'type'     => 'typography',
			'group'    => 'Karma Construction Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
	]);


	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'group'          => 'Karma Construction Swiper',
		'include'        => ['arrows', 'pagination', 'arrows_color', 'arrows_size', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
		'prefix'         => 'karma_construction_swiper_',
		'dependency'     => ['template', ['karma_construction_layout1']]
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => 'Karma Construction Image Size',
		'prefix'     => 'karma_construction_',
		'dependency' => ['template', ['karma_construction_layout1']]
	]);
}

function karma_construction_testimonials_layout1_addon_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_construction_use_quote_typo']) && !empty($shortcode->atts['karma_construction_quote_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__title-wrap:after'], $shortcode->parse_typography($shortcode->atts['karma_construction_quote_typo']));
	}
	if ( !empty($shortcode->atts['karma_construction_pos_use_typo']) && !empty($shortcode->atts['karma_construction_pos_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['karma_construction_pos_typo']));
	}
	if ( !empty($shortcode->atts['karma_construction_name_use_typo']) && !empty($shortcode->atts['karma_construction_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['karma_construction_name_typo']));
	}
	return $css;
}

add_filter('aheto_testimonials_dynamic_css', 'karma_construction_testimonials_layout1_addon_dynamic_css', 10, 2);