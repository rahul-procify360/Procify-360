<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'funero_testimonials_layout3');

/**
 * Testimonial Shortcode
 */

function funero_testimonials_layout3($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('funero_layout3', [
		'title' => esc_html__('Testimonials 8', 'funero'),
		'image' => $preview_dir . 'funero_layout3.jpg',
	]);

	$shortcode->add_dependecy('funero_testimonials_grid', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_text_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_text_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_text_typo', 'funero_text_use_typo', 'true');
	$shortcode->add_dependecy('funero_name_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_name_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_name_typo', 'funero_name_use_typo', 'true');
	$shortcode->add_dependecy('funero_date_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_date_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_date_typo', 'funero_date_use_typo', 'true');

	$shortcode->add_params([
		'funero_testimonials_grid' => [
			'type'    => 'group',
			'heading' => esc_html__('Testimonials Items', 'funero'),
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
	]);
}

function funero_testimonials_layout3_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_text_use_typo']) &&  $shortcode->atts['funero_text_use_typo'] && isset($shortcode->atts['funero_text_typo']) && !empty($shortcode->atts['funero_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__blockquote'], $shortcode->parse_typography($shortcode->atts['funero_text_typo']));
	}
	if ( isset($shortcode->atts['funero_name_use_typo']) && $shortcode->atts['funero_name_use_typo'] && isset($shortcode->atts['funero_name_typo']) && !empty($shortcode->atts['funero_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['funero_name_typo']));
	}
	if ( isset($shortcode->atts['funero_date_use_typo']) && $shortcode->atts['funero_date_use_typo'] && isset($shortcode->atts['funero_date_typo']) && !empty($shortcode->atts['funero_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__date'], $shortcode->parse_typography($shortcode->atts['funero_date_typo']));
	}
	return $css;
}
add_filter('aheto_testimonials_dynamic_css', 'funero_testimonials_layout3_css', 10, 2);
