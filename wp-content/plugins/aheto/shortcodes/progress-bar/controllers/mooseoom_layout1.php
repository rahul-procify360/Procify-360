<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'mooseoom_progress_bar_layout1');
/**
 * Progress Bar Shortcode
 */

function mooseoom_progress_bar_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('mooseoom_layout1', [
		'title' => esc_html__('Progress Bar 10', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	]);

	$shortcode->add_dependecy('mooseoom_use_text_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_text_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_text_typo', 'mooseoom_use_text_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_number_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_number_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_number_typo', 'mooseoom_use_number_typo', 'true');

	$shortcode->add_dependecy('mooseoom_title_tag', 'template', 'mooseoom_layout1');

	$shortcode->add_dependecy('mooseoom_number', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_text_tag', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_number_tag', 'template', 'mooseoom_layout1');

	aheto_demos_add_dependency('heading', ['mooseoom_layout1'], $shortcode);

	$shortcode->add_params([
		'mooseoom_use_number_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for numbers?', 'mooseoom'),
		],

		'mooseoom_number_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Numbers Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__number',
		],
		'mooseoom_number'    => [
			'type'    => 'text',
			'heading' => esc_html__('Number', 'mooseoom'),
			'grid'    => 1,
		],
		'mooseoom_text_tag' => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for heading', 'mooseoom'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h4',
			'grid'    => 1,
		],
		'mooseoom_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'mooseoom'),
			'grid'    => 3,
		],

		'mooseoom_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__dec',
		],
		'mooseoom_number_tag' => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for number', 'mooseoom'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h4',
			'grid'    => 5,
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'mooseoom_',
		'dependency' => ['template', ['mooseoom_layout1']]
	]);
}

function mooseoom_progress_bar_layout1_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['mooseoom_use_number_typo']) && !empty($shortcode->atts['mooseoom_number_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography($shortcode->atts['mooseoom_number_typo']));
	}
	if (!empty($shortcode->atts['mooseoom_use_text_typo']) && !empty($shortcode->atts['mooseoom_text_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-counter__dec'], $shortcode->parse_typography($shortcode->atts['mooseoom_text_typo']));
	}
	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'mooseoom_progress_bar_layout1_dynamic_css', 10, 2);
