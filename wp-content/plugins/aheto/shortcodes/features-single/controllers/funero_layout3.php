<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'funero_features_single_layout3');

/**
 * Features Banner Slider
 */

function funero_features_single_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('funero_layout3', [
		'title' => esc_html__('Features Single 17', 'funero'),
		'image' => $preview_dir . 'funero_layout3.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading'], ['funero_layout3'], $shortcode);
	$shortcode->add_dependecy('funero_subtitle', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_title', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_image', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_desc', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_link_title', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_link_url', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_subtitle_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_subtitle_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_subtitle_typo', 'funero_subtitle_use_typo', 'true');
	$shortcode->add_dependecy('funero_desc_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_desc_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_desc_typo', 'funero_desc_use_typo', 'true');
	$shortcode->add_dependecy('funero_link_use_typo', 'template', ['funero_layout3']);
	$shortcode->add_dependecy('funero_link_typo', 'template', 'funero_layout3');
	$shortcode->add_dependecy('funero_link_typo', 'funero_link_use_typo', 'true');
	$shortcode->add_params([
		'funero_subtitle'          => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'funero'),
		],
		'funero_title'             => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'funero'),
		],
		'funero_desc'              => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'funero'),
		],
		'funero_image'             => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image', 'funero'),
		],
		'funero_link_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'funero'),
		],
		'funero_link_url'          => [
			'type'    => 'link',
			'heading' => esc_html__('Link URL', 'funero'),
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
		'funero_desc_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'funero'),
			'grid'    => 3,
		],
		'funero_desc_typo'         => [
			'type'     => 'typography',
			'group'    => 'Funero Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__desc',
		],
		'funero_link_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'funero'),
			'grid'    => 3,
		],
		'funero_link_typo'         => [
			'type'     => 'typography',
			'group'    => 'Funero Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__link',
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'    => 'Funero Image',
		'dependency' => ['template', ['funero_layout3']]
	]);
}

function funero_features_single_layout3_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['funero_subtitle_use_typo']) && $shortcode->atts['funero_subtitle_use_typo'] && isset($shortcode->atts['funero_subtitle_typo']) && !empty($shortcode->atts['funero_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__subtitle'], $shortcode->parse_typography($shortcode->atts['funero_subtitle_typo']));
	}
	if ( isset($shortcode->atts['funero_desc_use_typo']) && $shortcode->atts['funero_desc_use_typo'] && isset($shortcode->atts['funero_desc_typo']) && !empty($shortcode->atts['funero_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__desc'], $shortcode->parse_typography($shortcode->atts['funero_desc_typo']));
	}
	if ( isset($shortcode->atts['funero_link_use_typo']) && $shortcode->atts['funero_link_use_typo'] && isset($shortcode->atts['funero_link_typo']) && !empty($shortcode->atts['funero_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__link'], $shortcode->parse_typography($shortcode->atts['funero_link_typo']));
	}
	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'funero_features_single_layout3_dynamic_css', 10, 2);
