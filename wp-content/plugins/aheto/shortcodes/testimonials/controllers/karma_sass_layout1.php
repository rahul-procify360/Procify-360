<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'karma_sass_testimonials_layout1');

/**
 * Testimonials
 */

function karma_sass_testimonials_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('karma_sass_layout1', [
		'title' => esc_html__('Karma Sass Modern', 'karma'),
		'image' => $preview_dir . 'karma_sass_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_sass_testimonials', 'template', ['karma_sass_layout1']);

	$shortcode->add_dependecy('karma_sass_use_quote_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_quote_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_quote_typo', 'karma_sass_use_quote_typo', 'true');

	$shortcode->add_dependecy('karma_sass_name_use_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_name_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_name_typo', 'karma_sass_name_use_typo', 'true');

	$shortcode->add_dependecy('karma_sass_subtitle_use_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_subtitle_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_subtitle_typo', 'karma_sass_subtitle_use_typo', 'true');

	$shortcode->add_params([
		'karma_sass_testimonials'   => [
			'type'    => 'group',
			'heading' => esc_html__('Modern Testimonials Items', 'karma'),
			'params'  => [
				'karma_sass_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'karma'),
				],
				'karma_sass_bg_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Background Image', 'karma'),
				],
				'karma_sass_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'karma'),
					'default' => esc_html__('Author name', 'karma'),
				],
				'karma_sass_subtitle'     => [
					'type'    => 'text',
					'heading' => esc_html__('Subtitle', 'karma'),
					'default' => esc_html__('testimonials', 'karma'),
				],
				'karma_sass_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'karma'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'karma'),
				],
			],
		],
		'karma_sass_use_quote_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Quote?', 'karma'),
			'grid'    => 12,
			'default' => '',
		],
		'karma_sass_quote_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Sass Quote Typography',
			'settings' => [
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'karma_sass_name_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'karma'),
			'grid'    => 3,
		],
		'karma_sass_name_typo'      => [
			'type'     => 'typography',
			'group'    => 'Karma Sass Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'karma_sass_subtitle_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for subtitle?', 'karma'),
			'grid'    => 3,
		],
		'karma_sass_subtitle_typo'       => [
			'type'     => 'typography',
			'group'    => 'Karma Sass Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__subtitle',
		],
	]);


	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'include'        => ['slides', 'simulate_touch', 'slides', 'spaces', 'small', 'medium', 'large', 'arrows' ,'arrows_color', 'arrows_size','loop', 'autoplay', 'speed'],
		'prefix'         => 'karma_sass_tm_swiper_',
		'dependency'     => ['template', ['karma_sass_layout1']]
	]);
}

function karma_sass_testimonials_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_sass_use_quote_typo']) && !empty($shortcode->atts['karma_sass_quote_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['karma_sass_quote_typo']));
	}
	if ( !empty($shortcode->atts['karma_sass_subtitle_use_typo']) && !empty($shortcode->atts['karma_sass_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_sass_subtitle_typo']));
	}
	if ( !empty($shortcode->atts['karma_sass_name_use_typo']) && !empty($shortcode->atts['karma_sass_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['karma_sass_name_typo']));
	}
	return $css;
}

add_filter('aheto_testimonials_dynamic_css', 'karma_sass_testimonials_layout1_dynamic_css', 10, 2);