<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'soapy_progress_bar_layout1');
/**
 * Progress Bar Shortcode
 */

function soapy_progress_bar_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Progress Bar 18', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency('heading', ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_number', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_use_title_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_title_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_title_typo', 'soapy_use_title_typo', 'true');
	$shortcode->add_dependecy('soapy_use_num_typo', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_num_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_num_typo', 'soapy_use_num_typo', 'true');


	$shortcode->add_params([
		'soapy_number'         => [
			'type'    => 'text',
			'heading' => esc_html__('Number', 'soapy'),
		],
		'soapy_use_num_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for numbers?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_num_typo'       => [
			'type'     => 'typography',
			'group'    => 'Soapy Numbers Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__chart',
		],
		'soapy_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__title',
		],
	]);


}
function soapy_progress_bar_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['soapy_use_num_typo']) && $shortcode->atts['soapy_use_num_typo'] && isset($shortcode->atts['soapy_num_typo']) && !empty($shortcode->atts['soapy_num_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__chart'], $shortcode->parse_typography($shortcode->atts['soapy_num_typo']));
	}
	if ( isset($shortcode->atts['soapy_use_title_typo']) && $shortcode->atts['soapy_use_title_typo'] && isset($shortcode->atts['soapy_title_typo']) && !empty($shortcode->atts['soapy_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['soapy_title_typo']));
	}

	return $css;
}

add_filter('aheto_progress_bar_dynamic_css', 'soapy_progress_bar_layout1_dynamic_css', 10, 2);
