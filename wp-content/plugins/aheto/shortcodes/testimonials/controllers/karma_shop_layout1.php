<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'karma_shop_testimonials_layout1');

/**
 * Testimonials
 */

function karma_shop_testimonials_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('karma_shop_layout1', [
		'title' => esc_html__('Testimonials 14', 'karma'),
		'image' => $preview_dir . 'karma_shop_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_shop_testimonials', 'template', ['karma_shop_layout1']);
	$shortcode->add_dependecy('karma_shop_use_quote_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_quote_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_quote_typo', 'karma_shop_use_quote_typo', 'true');
	$shortcode->add_dependecy('karma_shop_name_use_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_name_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_name_typo', 'karma_shop_name_use_typo', 'true');
	$shortcode->add_dependecy('karma_shop_pos_use_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_pos_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_pos_typo', 'karma_shop_pos_use_typo', 'true');
	$shortcode->add_dependecy('karma_shop_star_use_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_star_typo', 'template', 'karma_shop_layout1');
	$shortcode->add_dependecy('karma_shop_star_typo', 'karma_shop_star_use_typo', 'true');

	$shortcode->add_params([
		'karma_shop_testimonials'   => [
			'type'    => 'group',
			'heading' => esc_html__('Modern Testimonials Items', 'karma'),
			'params'  => [
				'karma_shop_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'karma'),
				],
				'karma_shop_rating'      => [
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
				'karma_shop_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'karma'),
					'default' => esc_html__('Author name', 'karma'),
				],
				'karma_shop_company'     => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'karma'),
					'default' => esc_html__('Author position', 'karma'),
				],
				'karma_shop_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'karma'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'karma'),
				],
			],
		],
		'karma_shop_use_quote_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Quote?', 'karma'),
			'grid'    => 12,
			'default' => '',
		],
		'karma_shop_quote_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Quote Typography',
			'settings' => [
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'karma_shop_name_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'karma'),
			'grid'    => 3,
		],
		'karma_shop_name_typo'      => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'karma_shop_pos_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Position?', 'karma'),
			'grid'    => 3,
		],
		'karma_shop_pos_typo'       => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
		'karma_shop_star_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Stars?', 'karma'),
			'grid'    => 3,
		],
		'karma_shop_star_typo'      => [
			'type'     => 'typography',
			'group'    => 'Karma Shop Stars Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__stars',
		],
	]);


	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'group'          => 'Karma Shop Swiper',
		'include'        => ['slides','simulate_touch', 'spaces', 'pagination', 'loop', 'autoplay', 'speed'],
		'prefix'         => 'karma_shop_tm_swiper_',
		'dependency'     => ['template', ['karma_shop_layout1']]
	]);
}

function karma_shop_testimonials_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_shop_use_quote_typo']) && !empty($shortcode->atts['karma_shop_quote_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['karma_shop_quote_typo']));
	}
	if ( !empty($shortcode->atts['karma_shop_pos_use_typo']) && !empty($shortcode->atts['karma_shop_pos_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['karma_shop_pos_typo']));
	}
	if ( !empty($shortcode->atts['karma_shop_star_use_typo']) && !empty($shortcode->atts['karma_shop_star_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__stars'], $shortcode->parse_typography($shortcode->atts['karma_shop_star_typo']));
	}
	if ( !empty($shortcode->atts['karma_shop_name_use_typo']) && !empty($shortcode->atts['karma_shop_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['karma_shop_name_typo']));
	}
	return $css;
}

add_filter('aheto_testimonials_dynamic_css', 'karma_shop_testimonials_layout1_dynamic_css', 10, 2);