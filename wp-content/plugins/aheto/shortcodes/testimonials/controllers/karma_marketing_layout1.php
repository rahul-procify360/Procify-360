<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'karma_marketing_testimonials_layout1');

/**
 * Testimonials
 */

function karma_marketing_testimonials_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('karma_marketing_layout1', [
		'title' => esc_html__('Testimonials 13', 'karma'),
		'image' => $preview_dir . 'karma_marketing_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_marketing_pos_active', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_arrow_border', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_arrow_hover', 'template', ['karma_marketing_layout1']);
	$shortcode->add_dependecy('karma_marketing_testimonials', 'template', ['karma_marketing_layout1']);

	$shortcode->add_dependecy('karma_marketing_use_quote_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_quote_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_quote_typo', 'karma_marketing_use_quote_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_name_use_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_name_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_name_typo', 'karma_marketing_name_use_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_pos_use_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_pos_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_pos_typo', 'karma_marketing_pos_use_typo', 'true');

	$shortcode->add_dependecy('karma_marketing_star_use_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_star_typo', 'template', 'karma_marketing_layout1');
	$shortcode->add_dependecy('karma_marketing_star_typo', 'karma_marketing_star_use_typo', 'true');

	$shortcode->add_params([
		'karma_marketing_testimonials'   => [
			'type'    => 'group',
			'heading' => esc_html__('Modern Testimonials Items', 'karma'),
			'params'  => [
				'karma_marketing_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'karma'),
				],
				'karma_marketing_rating'      => [
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
				'karma_marketing_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'karma'),
					'default' => esc_html__('Author name', 'karma'),
				],
				'karma_marketing_company'     => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'karma'),
					'default' => esc_html__('Author position', 'karma'),
				],
				'karma_marketing_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'karma'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'karma'),
				],
			],
		],
		'karma_marketing_use_quote_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Quote?', 'karma'),
			'grid'    => 12,
			'default' => '',
		],
		'karma_marketing_quote_typo'     => [
			'type'     => 'typography',
			'group'    => 'Quote Typography',
			'settings' => [
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'karma_marketing_name_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_name_typo'      => [
			'type'     => 'typography',
			'group'    => 'Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'karma_marketing_pos_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Position?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_pos_typo'       => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
		'karma_marketing_star_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Stars?', 'karma'),
			'grid'    => 3,
		],
		'karma_marketing_star_typo'       => [
			'type'     => 'typography',
			'group'    => 'Stars Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__stars',
		],
		'karma_marketing_pos_active' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Position color for active slide', 'karma' ),
			'grid'      => 6,
			'default'   => 'transparent',
			'selectors' => [
				'{{WRAPPER}} .swiper-slide-next .aheto-tm__position' => 'color: {{VALUE}};',
			],
		],
		'karma_marketing_arrow_border' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Arrow border color', 'karma' ),
			'grid'      => 6,
			'default'   => 'transparent',
			'selectors' => [
				'{{WRAPPER}} .swiper-button-next, {{WRAPPER}} .swiper-button-prev' => 'border-color: {{VALUE}};',
			],
		],
		'karma_marketing_arrow_hover' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Position color for active slide', 'karma' ),
			'grid'      => 6,
			'default'   => 'transparent',
			'selectors' => [
				'{{WRAPPER}} .swiper-button-next:hover, {{WRAPPER}} .swiper-button-prev:hover' => 'background-color: {{VALUE}};',
			],
		],
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
	    'group'      => esc_html__( 'Karma Marketing Swiper ', 'karma' ),
		'custom_options' => true,
		'include'        => ['arrows', 'arrows_color', 'arrows_size', 'loop', 'autoplay', 'speed'],
		'prefix'         => 'karma_marketing_tm_swiper_',
		'dependency'     => ['template', ['karma_marketing_layout1']]
	]);

}

function karma_marketing_testimonials_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_marketing_use_quote_typo']) && !empty($shortcode->atts['karma_marketing_quote_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['karma_marketing_quote_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_pos_use_typo']) && !empty($shortcode->atts['karma_marketing_pos_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['karma_marketing_pos_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_star_use_typo']) && !empty($shortcode->atts['karma_marketing_star_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__stars'], $shortcode->parse_typography($shortcode->atts['karma_marketing_star_typo']));
	}

	if ( !empty($shortcode->atts['karma_marketing_name_use_typo']) && !empty($shortcode->atts['karma_marketing_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['karma_marketing_name_typo']));
	}

	if ( ! empty( $shortcode->atts['karma_marketing_pos_active'] ) ) {
		$color                                                    = Sanitize::color( $shortcode->atts['karma_marketing_pos_active'] );
		$css['global']['%1$s .swiper-slide-next .aheto-tm__position']['color'] = $color;
	}

	if ( ! empty( $shortcode->atts['karma_marketing_arrow_border'] ) ) {
		$color                                                    = Sanitize::color( $shortcode->atts['karma_marketing_arrow_border'] );
		$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['border-color'] = $color;
	}

	if ( ! empty( $shortcode->atts['karma_marketing_arrow_hover'] ) ) {
		$color                                                    = Sanitize::color( $shortcode->atts['karma_marketing_arrow_hover'] );
		$css['global']['%1$s .swiper-button-next:hover, %1$s .swiper-button-prev:hover']['background-color'] = $color;
	}

	return $css;

}

add_filter('aheto_testimonials_dynamic_css', 'karma_marketing_testimonials_layout1_dynamic_css', 10, 2);