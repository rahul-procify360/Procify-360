<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'famulus_features_single_layout2');


/**
 * Feature Single
 */

function famulus_features_single_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Features Single 8', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	aheto_demos_add_dependency(['s_image','s_heading', 's_description','use_heading', 't_heading', 'use_description', 't_description' ], ['famulus_layout2'], $shortcode);

	$shortcode->add_dependecy('align', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_bg_color', 'template', 'famulus_layout2');

	$shortcode->add_params([
		'align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'famulus'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'famulus_bg_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__('Color on background', 'famulus'),
			'grid' => 6,
			'selectors' => ['{{WRAPPER}} .aheto-content-block__img-wrap::before' => 'background-color: {{VALUE}}'],
		],
	]);
}

function famulus_features_single_layout2_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['famulus_bg_color'])) {
		$color = Sanitize::color($shortcode->atts['famulus_bg_color']);
		$css['global']['%1$s .aheto-content-block__img-wrap::before']['background-color'] = $color;
	}
	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'famulus_features_single_layout2_dynamic_css', 10, 2);