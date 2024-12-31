<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'famulus_features_single_layout7');


/**
 * Feature Single
 */

function famulus_features_single_layout7($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('famulus_layout7', [
		'title' => esc_html__('Features Single 13', 'famulus'),
		'image' => $preview_dir . 'famulus_layout7.jpg',
	]);

	aheto_demos_add_dependency(['s_image', 's_heading', 's_description'], ['famulus_layout7'], $shortcode);

	$shortcode->add_dependecy('famulus_logo', 'template', 'famulus_layout7');
	$shortcode->add_dependecy('famulus_title_use_typo', 'template', 'famulus_layout7');
	$shortcode->add_dependecy('famulus_title_typo', 'template', 'famulus_layout7');
	$shortcode->add_dependecy('famulus_title_typo', 'famulus_title_use_typo', 'true');
	$shortcode->add_dependecy('famulus_desc_use_typo', 'template', 'famulus_layout7');
	$shortcode->add_dependecy('famulus_desc_typo', 'template', 'famulus_layout7');
	$shortcode->add_dependecy('famulus_desc_typo', 'famulus_desc_use_typo', 'true');

	$shortcode->add_params([
		'famulus_logo' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Add logo', 'famulus'),
		],
		'famulus_title_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Famulus Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__title',
		],
		'famulus_desc_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_desc_typo'         => [
			'type'     => 'typography',
			'group'    => 'Famulus Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__info-text'
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'famulus_',
		'dependency' => ['template', ['famulus_layout7']]
	]);
}

function famulus_features_single_layout7_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_title_use_typo']) && $shortcode->atts['famulus_title_use_typo'] && isset($shortcode->atts['famulus_title_typo']) && !empty($shortcode->atts['famulus_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__title'], $shortcode->parse_typography($shortcode->atts['famulus_title_typo']));
	}
	if ( isset($shortcode->atts['famulus_desc_use_typo']) && $shortcode->atts['famulus_desc_use_typo'] && isset($shortcode->atts['famulus_desc_typo']) && !empty($shortcode->atts['famulus_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__info-text '], $shortcode->parse_typography($shortcode->atts['famulus_desc_typo']));
	}

	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'famulus_features_single_layout7_dynamic_css', 10, 2);

