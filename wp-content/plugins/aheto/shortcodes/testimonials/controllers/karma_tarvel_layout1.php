<?php

use Aheto\Helper;

if(!function_exists('karma_travel_testimonials_layout1')){

	add_action('aheto_before_aheto_testimonials_register', 'karma_travel_testimonials_layout1');

	/**
	 * Testimonials
	 */
	function karma_travel_testimonials_layout1($shortcode) {

		$preview_dir = '//assets.aheto.co/testimonials/previews/';

		$shortcode->add_layout('karma_travel_layout1', [
			'title' => esc_html__('Karma Travel Modern', 'karma'),
			'image' => $preview_dir . 'karma_travel_layout1.jpg',
		]);

		$shortcode->add_dependecy('karma_travel_testimonials', 'template', ['karma_travel_layout1']);

		$shortcode->add_dependecy('karma_travel_use_quote_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_quote_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_quote_typo', 'karma_travel_use_quote_typo', 'true');

		$shortcode->add_dependecy('karma_travel_name_use_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_name_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_name_typo', 'karma_travel_name_use_typo', 'true');

		$shortcode->add_dependecy('karma_travel_pos_use_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_pos_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_pos_typo', 'karma_travel_pos_use_typo', 'true');

		$shortcode->add_dependecy('karma_travel_star_use_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_star_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_star_typo', 'karma_travel_star_use_typo', 'true');

		$shortcode->add_dependecy('karma_travel_title_use_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_title_typo', 'template', 'karma_travel_layout1');
		$shortcode->add_dependecy('karma_travel_title_typo', 'karma_travel_title_use_typo', 'true');

		$shortcode->add_params([
			'karma_travel_testimonials'   => [
				'type'    => 'group',
				'heading' => esc_html__('Modern Testimonials Items', 'karma'),
				'params'  => [
					'karma_travel_title'        => [
						'type'    => 'text',
						'heading' => esc_html__('Title', 'karma'),
						'default' => esc_html__('', 'karma'),
					],
					'karma_travel_image'       => [
						'type'    => 'attach_image',
						'heading' => esc_html__('Display Image', 'karma'),
					],
					'karma_travel_image_quote'       => [
						'type'    => 'attach_image',
						'heading' => esc_html__('Display Image Quote', 'karma'),
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
					'karma_travel_name'        => [
						'type'    => 'text',
						'heading' => esc_html__('Name', 'karma'),
						'default' => esc_html__('Author name', 'karma'),
					],
					'karma_travel_company'     => [
						'type'    => 'text',
						'heading' => esc_html__('Position', 'karma'),
						'default' => esc_html__('Author position', 'karma'),
					],
					'karma_travel_testimonial' => [
						'type'    => 'textarea',
						'heading' => esc_html__('Testimonial', 'karma'),
						'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'karma'),
					],
				],
			],
			'karma_travel_use_quote_typo' => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for Quote?', 'karma'),
				'grid'    => 12,
				'default' => '',
			],
			'karma_travel_quote_typo'     => [
				'type'     => 'typography',
				'group'    => 'Karma Travel Quote Typography',
				'settings' => [
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-tm__text',
			],
			'karma_travel_name_use_typo'  => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for Name?', 'karma'),
				'grid'    => 3,
			],
			'karma_travel_name_typo'      => [
				'type'     => 'typography',
				'group'    => 'Karma Travel Name Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-tm__name',
			],
			'karma_travel_pos_use_typo'   => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for Position?', 'karma'),
				'grid'    => 3,
			],
			'karma_travel_pos_typo'       => [
				'type'     => 'typography',
				'group'    => 'Karma Travel Position Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-tm__position',
			],
			'karma_travel_star_use_typo'   => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for Stars?', 'karma'),
				'grid'    => 3,
			],
			'karma_travel_star_typo'       => [
				'type'     => 'typography',
				'group'    => 'Karma Travel Stars Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => false,
				],
				'selector' => '{{WRAPPER}} .aheto-tm__stars',
			],
			'karma_travel_title_use_typo'   => [
				'type'    => 'switch',
				'heading' => esc_html__('Use custom font for title?', 'karma'),
				'grid'    => 3,
			],
			'karma_travel_title_typo'       => [
				'type'     => 'typography',
				'group'    => 'Karma Travel Title Typography',
				'settings' => [
					'tag'        => false,
					'text_align' => true,
				],
				'selector' => '{{WRAPPER}} .aheto-tm__title',
			],
		]);


		\Aheto\Params::add_carousel_params($shortcode, [
			'custom_options' => true,
			'include'        => ['slides', 'simulate_touch', 'spaces', 'arrows' ,'loop', 'autoplay', 'speed', 'arrows_color', 'arrows_size'],
			'prefix'         => 'karma_travel_tm_swiper_',
			'dependency'     => ['template', ['karma_travel_layout1']]
		]);
	}
}

if(!function_exists('karma_travel_testimonials_layout1_dynamic_css')) {
	function karma_travel_testimonials_layout1_dynamic_css( $css, $shortcode ) {

		if ( ! empty( $shortcode->atts['karma_travel_use_quote_typo'] ) && ! empty( $shortcode->atts['karma_travel_quote_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['karma_travel_quote_typo'] ) );
		}
		if ( ! empty( $shortcode->atts['karma_travel_pos_use_typo'] ) && ! empty( $shortcode->atts['karma_travel_pos_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography( $shortcode->atts['karma_travel_pos_typo'] ) );
		}
		if ( ! empty( $shortcode->atts['karma_travel_star_use_typo'] ) && ! empty( $shortcode->atts['karma_travel_star_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-tm__stars'], $shortcode->parse_typography( $shortcode->atts['karma_travel_star_typo'] ) );
		}
		if ( ! empty( $shortcode->atts['karma_travel_name_use_typo'] ) && ! empty( $shortcode->atts['karma_travel_name_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography( $shortcode->atts['karma_travel_name_typo'] ) );
		}
		if ( ! empty( $shortcode->atts['karma_travel_title_use_typo'] ) && ! empty( $shortcode->atts['karma_travel_title_typo'] ) ) {
			\aheto_add_props( $css['global']['%1$s .aheto-tm__title'], $shortcode->parse_typography( $shortcode->atts['karma_travel_title_typo'] ) );
		}

		return $css;
	}

	add_filter( 'aheto_testimonials_dynamic_css', 'karma_travel_testimonials_layout1_dynamic_css', 10, 2 );
}