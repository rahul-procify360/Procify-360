<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'funero_testimonials_layout2');

/**
 * Testimonial Shortcode
 */

function funero_testimonials_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('funero_layout2', [
		'title' => esc_html__('Testimonials 7', 'funero'),
		'image' => $preview_dir . 'funero_layout2.jpg',
	]);

	$shortcode->add_dependecy('funero_testimonials_simple_item', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_text_use_typo', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_text_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_text_typo', 'funero_text_use_typo', 'true');
	$shortcode->add_dependecy('funero_name_use_typo', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_name_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_name_typo', 'funero_name_use_typo', 'true');
	$shortcode->add_dependecy('funero_date_use_typo', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_date_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_date_typo', 'funero_date_use_typo', 'true');
	$shortcode->add_dependecy('funero_big_spaces', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_arrows_use_typo', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_arrows_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_arrows_typo', 'funero_arrows_use_typo', 'true');

	$shortcode->add_params([
		'funero_testimonials_simple_item' => [
			'type'    => 'group',
			'heading' => esc_html__('Simple Testimonials Items', 'funero'),
			'params'  => [
				'funero_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'funero'),
				],
				'funero_date'        => [
					'type'    => 'text',
					'heading' => esc_html__('Date', 'funero'),
				],
				'funero_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'funero'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'funero'),
				],
				'funero_image_bg'    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image Background', 'funero'),
				],
			],
		],
		'funero_text_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Testimonials?', 'funero'),
			'grid'    => 3,
		],
		'funero_text_typo'                => [
			'type'     => 'typography',
			'group'    => 'Funero Testimonials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__blockquote',
		],
		'funero_name_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'funero'),
			'grid'    => 3,
		],
		'funero_name_typo'                => [
			'type'     => 'typography',
			'group'    => 'Funero Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'funero_date_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Date?', 'funero'),
			'grid'    => 3,
		],
		'funero_date_typo'                => [
			'type'     => 'typography',
			'group'    => 'Funero Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__date',
		],
		'funero_arrows_use_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Arrows?', 'funero'),
			'grid'    => 3,
		],
		'funero_arrows_typo'              => [
			'type'     => 'typography',
			'group'    => 'Funero Swiper',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-slides-prev, {{WRAPPER}} .swiper-slides-next',
		],
		'funero_big_spaces'               => [
			'type'    => 'switch',
			'heading' => esc_html__('Big Spaces?', 'funero'),
			'grid'    => 3,
		],
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'group'          => 'Funero Swiper',
		'custom_options' => true,
		'prefix'         => 'funero_swiper_',
		'include'        => ['pagination', 'speed', 'loop', 'autoplay', 'initial_slide', 'direction', 'arrows', 'arrows_style', 'spaces', 'slides', 'simulate_touch'],
		'dependency'     => ['template', ['funero_layout2']]
	]);


}

function funero_testimonials_layout2_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_text_use_typo']) &&  $shortcode->atts['funero_text_use_typo'] && isset($shortcode->atts['funero_text_typo'])  && !empty($shortcode->atts['funero_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__blockquote'], $shortcode->parse_typography($shortcode->atts['funero_text_typo']));
	}
	if ( isset($shortcode->atts['funero_name_use_typo']) && $shortcode->atts['funero_name_use_typo'] && isset($shortcode->atts['funero_name_typo']) && !empty($shortcode->atts['funero_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['funero_name_typo']));
	}
	if ( isset($shortcode->atts['funero_date_use_typo']) && $shortcode->atts['funero_date_use_typo'] && isset($shortcode->atts['funero_date_typo'])  && !empty($shortcode->atts['funero_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__date'], $shortcode->parse_typography($shortcode->atts['funero_date_typo']));
	}
	if ( isset($shortcode->atts['funero_arrows_use_typo']) && $shortcode->atts['funero_arrows_use_typo'] && isset($shortcode->atts['funero_arrows_typo'])  && !empty($shortcode->atts['funero_arrows_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-slides-prev, %1$s .swiper-slides-next'], $shortcode->parse_typography($shortcode->atts['funero_arrows_typo']));
	}
	return $css;
}

add_filter('aheto_testimonials_dynamic_css', 'funero_testimonials_layout2_css', 10, 2);
