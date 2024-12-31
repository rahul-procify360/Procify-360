<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'soapy_features_single_layout4');


/**
 * Feature Single
 */

function soapy_features_single_layout4($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('soapy_layout4', [
		'title' => esc_html__('Features Single 51', 'soapy'),
		'image' => $preview_dir . 'soapy_layout4.jpg',
	]);
	aheto_demos_add_dependency(['use_heading', 't_heading'], ['soapy_layout4'], $shortcode);

	$shortcode->add_dependecy('soapy_image_bg', 'template', 'soapy_layout4');
	$shortcode->add_dependecy('soapy_image_num', 'template', 'soapy_layout4');
	$shortcode->add_dependecy('soapy_number', 'template', 'soapy_layout4');
	$shortcode->add_dependecy('soapy_num_use_typo', 'template', 'soapy_layout4');
	$shortcode->add_dependecy('soapy_num_typo', 'template', 'soapy_layout4');
	$shortcode->add_dependecy('soapy_num_typo', 'soapy_num_use_typo', 'true');


	$shortcode->add_params([
		'soapy_image_bg'    => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image', 'soapy'),
		],
		'soapy_image_num'          => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Background Image for Number', 'soapy'),
		],
		'soapy_number'             => [
			'type'    => 'text',
			'heading' => esc_html__('Number', 'soapy'),
		],
		'soapy_num_use_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Number?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_num_typo'           => [
			'type'     => 'typography',
			'group'    => 'Soapy Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__number',
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'dependency' => ['template', ['soapy_layout4']]
	]);
}

function soapy_features_single_layout4_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['soapy_num_use_typo']) && $shortcode->atts['soapy_num_use_typo'] && isset($shortcode->atts['soapy_num_typo']) && !empty($shortcode->atts['soapy_num_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__number'], $shortcode->parse_typography($shortcode->atts['soapy_num_typo']));
	}
	return $css;
}
add_filter('aheto_features_single_dynamic_css', 'soapy_features_single_layout4_dynamic_css', 10, 2);
