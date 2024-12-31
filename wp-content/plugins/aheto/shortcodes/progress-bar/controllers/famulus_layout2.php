<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'famulus_progress_bar_layout2');
/**
 * Progress Bar Shortcode
 */

function famulus_progress_bar_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Progress Bar 5', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	aheto_demos_add_dependency(['percentage', 'heading'], ['famulus_layout2'], $shortcode);

	$shortcode->add_dependecy('famulus_num_use_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_num_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_num_typo', 'famulus_num_use_typo', 'true');
	$shortcode->add_params([
		'famulus_num_use_typo'    => [
		'type'    => 'switch',
		'heading' => esc_html__('Use custom font for numbers?', 'famulus'),
		'grid'    => 3,
	],
		'famulus_num_typo'        => [
		'type'     => 'typography',
		'group'    => 'Famulus Numbers Typography',
		'settings' => [
			'tag'        => false,
			'text_align' => false,
		],
		'selector' => '{{WRAPPER}} .aheto-progress__bar-holder',
	],
	]);
}
function famulus_progress_bar_layout2_dynamic_css($css, $shortcode) {
	
	if ( isset($shortcode->atts['famulus_num_use_typo']) && $shortcode->atts['famulus_num_use_typo'] && isset($shortcode->atts['famulus_num_typo']) && !empty($shortcode->atts['famulus_num_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__bar-holder'], $shortcode->parse_typography($shortcode->atts['famulus_num_typo']));
	}
	return $css;
}

add_filter('aheto_progress_bar_dynamic_css', 'famulus_progress_bar_layout2_dynamic_css', 10, 2);