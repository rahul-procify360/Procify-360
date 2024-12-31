<?php

use Aheto\Helper;

add_action('aheto_before_aheto_title-bar_register', 'karma_travel_title_bar_layout1');

/**
 * Title Bar Shortcode
 */

function karma_travel_title_bar_layout1($shortcode) {
	$preview_dir =  '//assets.aheto.co/title-bar/previews/';

	$shortcode->add_layout('karma_travel_layout1', [
		'title' => esc_html__('Karma Travel Seacrh Bar', 'karma_travel'),
		'image' => $preview_dir . 'karma_travel_layout1.jpg',
	]);

	aheto_demos_add_dependency(['searchform'], ['karma_travel_layout1'], $shortcode);
	$shortcode->add_dependecy('karma_travel_input', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_submit', 'template', 'karma_travel_layout1');


	$shortcode->add_dependecy('karma_travel_submit_use_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_submit_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_submit_typo', 'karma_travel_submit_use_typo', 'true');

	$shortcode->add_dependecy('karma_travel_input_use_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_input_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_input_typo', 'karma_travel_input_use_typo', 'true');

	$shortcode->add_params([
		'karma_travel_input'        => [
			'type'    => 'text',
			'heading' => esc_html__('Input Placeholder', 'karma'),
			'default' => esc_html__('Placeholder', 'karma'),
		],
		'karma_travel_submit'        => [
			'type'    => 'text',
			'heading' => esc_html__('Submit text', 'karma'),
			'default' => esc_html__('Submit', 'karma'),
		],
		'karma_travel_submit_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for submit?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_submit_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Travel Submit Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} input[type="submit"]',
		],
		'karma_travel_input_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for input?', 'karma'),
			'grid'    => 3,
		],
		'karma_travel_input_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Travel Input Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} input[type="text"]::placeholder',
		],
	]);
	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon' => true,
		'exclude'  => ['align'],
		'dependency' => ['template', ['karma_travel_layout1']]
	]);
}

function karma_travel_title_bar_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_travel_submit_use_typo']) && !empty($shortcode->atts['karma_travel_submit_typo']) ) {
		\aheto_add_props($css['global']['%1$s input[type="submit"]'], $shortcode->parse_typography($shortcode->atts['karma_travel_submit_typo']));
	}
	if ( !empty($shortcode->atts['karma_travel_input_use_typo']) && !empty($shortcode->atts['karma_travel_input_typo']) ) {
		\aheto_add_props($css['global']['%1$s input[type="text"]::placeholder'], $shortcode->parse_typography($shortcode->atts['karma_travel_input_typo']));
	}
	return $css;
}

add_filter('karma_travel_title_bar_dynamic_css', 'karma_travel_title_bar_layout1_dynamic_css', 10, 2);
