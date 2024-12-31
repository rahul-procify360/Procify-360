<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'funero_features_single_layout2');

/**
 * Features Banner Slider
 */

function funero_features_single_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('funero_layout2', [
		'title' => esc_html__('Features Single 16', 'funero'),
		'image' => $preview_dir . 'funero_layout2.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading'], ['funero_layout2'], $shortcode);

	$shortcode->add_dependecy('funero_title', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_image', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_desc', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_desc_use_typo', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_desc_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_desc_typo', 'funero_desc_use_typo', 'true');
	$shortcode->add_dependecy('funero_title_top', 'template', ['funero_layout2']);
	
	$shortcode->add_params([
		'funero_title'             => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'funero'),
		],
		'funero_title_top'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Move title to the top?', 'funero'),
			'grid'    => 3,
		],
		'funero_desc'              => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'funero'),
		],
		'funero_image'             => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image', 'funero'),
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
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'    => 'Funero Image',
		'dependency' => ['template', ['funero_layout2']]
	]);
}

function funero_features_single_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_desc_use_typo']) &&  $shortcode->atts['funero_desc_use_typo'] && isset($shortcode->atts['funero_desc_typo']) && !empty($shortcode->atts['funero_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__desc'], $shortcode->parse_typography($shortcode->atts['funero_desc_typo']));
	}
	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'funero_features_single_layout2_dynamic_css', 10, 2);
