<?php

use Aheto\Helper;

add_action('aheto_before_aheto_title-bar_register', 'karma_education_title_bar_layout1');

/**
 * Title Bar Shortcode
 */

function karma_education_title_bar_layout1($shortcode) {
	$preview_dir = get_template_directory_uri() . '/aheto/title-bar/previews/';

	$shortcode->add_layout('karma_education_layout1', [
		'title' => esc_html__('Karma Education Seacrh Bar', 'karma_education'),
		'image' => $preview_dir . 'karma_education_layout1.jpg',
	]);

	karma_add_dependency(['searchform'], ['karma_education_layout1'], $shortcode);
	$shortcode->add_dependecy('karma_education_submit_use_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_submit_typo', 'template', 'karma_education_layout1');
	$shortcode->add_dependecy('karma_education_submit_typo', 'karma_education_submit_use_typo', 'true');

	$shortcode->add_params([
		'karma_education_submit_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for submit?', 'karma'),
			'grid'    => 3,
		],
		'karma_education_submit_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Education Submit Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} input[type="submit"]',
		],
	]);
}

function karma_education_title_bar_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_education_submit_use_typo']) && !empty($shortcode->atts['karma_education_submit_typo']) ) {
		\aheto_add_props($css['global']['%1$s input[type="submit"]'], $shortcode->parse_typography($shortcode->atts['karma_education_submit_typo']));
	}
	return $css;
}

add_filter('karma_education_title_bar_dynamic_css', 'karma_education_title_bar_layout1_dynamic_css', 10, 2);
