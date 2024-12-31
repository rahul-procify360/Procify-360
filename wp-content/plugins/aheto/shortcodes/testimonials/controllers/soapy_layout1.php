<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'soapy_testimonials_layout1');

/**
 * Testimonials
 */

function soapy_testimonials_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Testimonials 26', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);
	$shortcode->add_dependecy('soapy_testimonials_simple_item', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_text_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_text_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_text_typo', 'soapy_text_use_typo', 'true');
	$shortcode->add_dependecy('soapy_name_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_name_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_name_typo', 'soapy_name_use_typo', 'true');
	$shortcode->add_dependecy('soapy_symbol_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_symbol_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_symbol_typo', 'soapy_symbol_use_typo', 'true');

	$shortcode->add_params([
		'soapy_testimonials_simple_item' => [
			'type'    => 'group',
			'heading' => esc_html__('Simple Testimonials Items', 'soapy'),
			'params'  => [
				'soapy_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'soapy'),
				],
				'soapy_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'soapy'),
					'default' => esc_html__('Author name', 'soapy'),
				],
				'soapy_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'soapy'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'soapy'),
				],
			],
		],
		'soapy_text_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for testimonials?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_text_typo'                => [
			'type'     => 'typography',
			'group'    => 'Soapy Testimonials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__blockquote',
		],
		'soapy_name_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_name_typo'                => [
			'type'     => 'typography',
			'group'    => 'Soapy Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'soapy_symbol_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for symbol?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_symbol_typo'                => [
			'type'     => 'typography',
			'group'    => 'Soapy Symbol Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__content::after',
		],
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'soapy_swiper_',
		'include'        => ['pagination', 'speed', 'loop', 'autoplay', 'arrows', 'spaces', 'slides', 'simulate_touch'],
		'dependency'     => ['template', ['soapy_layout1']]
	]);
}

function soapy_testimonials_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_text_use_typo']) && $shortcode->atts['soapy_text_use_typo'] && isset($shortcode->atts['soapy_text_typo']) && !empty($shortcode->atts['soapy_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__blockquote'], $shortcode->parse_typography($shortcode->atts['soapy_text_typo']));
	}
	if ( isset($shortcode->atts['soapy_name_use_typo']) && $shortcode->atts['soapy_name_use_typo'] && isset($shortcode->atts['soapy_name_typo']) && !empty($shortcode->atts['soapy_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['soapy_name_typo']));
	}
	if ( isset($shortcode->atts['soapy_symbol_use_typo']) && $shortcode->atts['soapy_symbol_use_typo'] && isset($shortcode->atts['soapy_symbol_typo']) && !empty($shortcode->atts['soapy_symbol_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__content::after'], $shortcode->parse_typography($shortcode->atts['soapy_symbol_typo']));
	}
	return $css;
}

add_filter('famulus_testimonials_dynamic_css', 'soapy_testimonials_layout1_dynamic_css', 10, 2);
