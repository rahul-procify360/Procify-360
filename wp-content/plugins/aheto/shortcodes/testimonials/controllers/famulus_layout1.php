<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'famulus_testimonials_layout1');

/**
 * Testimonials
 */

function famulus_testimonials_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Testimonials 5', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);
	$shortcode->add_dependecy('famulus_testimonials_simple_item', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_white_text', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo', 'famulus_text_use_typo', 'true');
	$shortcode->add_dependecy('famulus_position_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_position_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_position_typo', 'famulus_position_use_typo', 'true');
	$shortcode->add_dependecy('famulus_author_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_author_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_author_typo', 'famulus_author_use_typo', 'true');

	$shortcode->add_params([
		'famulus_testimonials_simple_item' => [
			'type'    => 'group',
			'heading' => esc_html__('Modern Testimonials Items', 'famulus'),
			'params'  => [
				'famulus_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'famulus'),
				],
				'famulus_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'famulus'),
					'default' => esc_html__('Author name', 'famulus'),
				],
				'famulus_company'     => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'famulus'),
					'default' => esc_html__('Author position', 'famulus'),
				],
				'famulus_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'famulus'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'famulus'),
				],
			],
		],
		'famulus_white_text'               => [
			'type'        => 'switch',
			'heading'     => esc_html__('Use White Text?', 'famulus'),
			'grid'        => 3,
			'description' => esc_html__('Works only for Name and Position', 'famulus'),

		],
		'famulus_text_use_typo'            => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Testimonials?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo'                => [
			'type'     => 'typography',
			'group'    => 'Famulus Testimonials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__blockquote',
		],
		'famulus_position_use_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Position?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_position_typo'            => [
			'type'     => 'typography',
			'group'    => 'Famulus Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
		'famulus_author_use_typo'          => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Author?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_author_typo'              => [
			'type'     => 'typography',
			'group'    => 'Famulus Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'famulus_swiper_',
		'include'        => ['pagination', 'speed', 'loop', 'autoplay', 'arrows', 'spaces', 'slides', 'simulate_touch'],
		'dependency'     => ['template', ['famulus_layout1']]
	]);
}

function famulus_testimonials_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_text_use_typo']) && $shortcode->atts['famulus_text_use_typo'] && isset($shortcode->atts['famulus_text_typo']) && !empty($shortcode->atts['famulus_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__blockquote'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo']));
	}
	if ( isset($shortcode->atts['famulus_position_use_typo']) && $shortcode->atts['famulus_position_use_typo'] && isset($shortcode->atts['famulus_position_typo']) && !empty($shortcode->atts['famulus_position_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['famulus_position_typo']));
	}
	if ( isset($shortcode->atts['famulus_author_use_typo']) && $shortcode->atts['famulus_author_use_typo'] && isset($shortcode->atts['famulus_author_typo']) && !empty($shortcode->atts['famulus_author_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['famulus_author_typo']));
	}
	return $css;
}

add_filter('famulus_testimonials_dynamic_css', 'famulus_testimonials_layout1_dynamic_css', 10, 2);
