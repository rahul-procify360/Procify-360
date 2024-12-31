<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'funero_features_single_layout1');

/**
 * Features Banner Slider
 */

function funero_features_single_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Features Single 15', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading'], ['funero_layout1'], $shortcode);

	$shortcode->add_dependecy('funero_text_bg', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_subtitle', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_title', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_image_bg', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_subtitle_use_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_subtitle_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_subtitle_typo', 'funero_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('funero_text_bg_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_text_bg_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_text_bg_typo', 'funero_text_bg_use_typo', 'true');
	$shortcode->add_params([

		'funero_text_bg'           => [
			'type'    => 'text',
			'heading' => esc_html__('Background text', 'funero'),
		],
		'funero_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'funero'),
		],
		'funero_title'             => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'funero'),
		],
		'funero_image_bg'          => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Background Image', 'funero'),
		],
		'funero_subtitle_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'funero'),
			'grid'    => 3,
		],
		'funero_subtitle_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__subtitle',
		],
		'funero_text_bg_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Text Background?', 'funero'),
			'grid'    => 3,
		],
		'funero_text_bg_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Text Background Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__text-bg',
		],

	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'    => 'Funero Image',
		'dependency' => ['template', ['funero_layout1']]
	]);
}

function funero_features_single_layout1_dynamic_css($css, $shortcode) {


	if ( isset($shortcode->atts['funero_text_bg_use_typo']) && $shortcode->atts['funero_text_bg_use_typo'] && isset($shortcode->atts['funero_text_bg_typo']) && !empty($shortcode->atts['funero_text_bg_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__text-bg'], $shortcode->parse_typography($shortcode->atts['funero_text_bg_typo']));
	}
	if ( isset($shortcode->atts['funero_subtitle_use_typo']) && $shortcode->atts['funero_subtitle_use_typo'] && isset($shortcode->atts['funero_subtitle_typo']) && !empty($shortcode->atts['funero_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__subtitle'], $shortcode->parse_typography($shortcode->atts['funero_subtitle_typo']));
	}
	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'funero_features_single_layout1_dynamic_css', 10, 2);
