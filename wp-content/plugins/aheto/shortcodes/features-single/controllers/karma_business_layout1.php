<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'karma_business_features_single_layout1');


/**
 * Navbar
 */


function karma_business_features_single_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout('karma_business_layout1', [
		'title' => esc_html__('Features Single 26', 'karma'),
		'image' => $preview_dir . 'karma_business_layout1.jpg',
	]);

	aheto_demos_add_dependency( [ 's_heading', 'use_heading', 't_heading' ], [ 'karma_business_layout1' ], $shortcode);

	$shortcode->add_dependecy('karma_business_use_title_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_title_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_title_typo', 'karma_business_use_title_typo', 'true');

	$shortcode->add_dependecy('karma_business_title_tag', 'template', 'karma_business_layout1');

	$shortcode->add_params([

		'karma_business_title_tag' => [
			'type'    => 'select',
			'heading' => esc_html__('Title tag', 'karma'),
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
			'default' => 'h2',
			'grid'    => 1,
		],

		'karma_business_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title text?', 'karma'),
		],
		'karma_business_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-single__title',
		],

	]);

	\Aheto\Params::add_button_params($shortcode, [
		'add_button' => true,
		'prefix' => 'karma_business_main_',
		'icons' => true,
		'align' => true,
		'dependency' => ['template', 'karma_business_layout1']
	]);

}

function karma_business_features_single_layout1_dynamic_css($css, $shortcode) {

	if (!empty($shortcode->atts['karma_business_use_title_typo']) && !empty($shortcode->atts['karma_business_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-title'], $shortcode->parse_typography($shortcode->atts['karma_business_title_typo']));
	}

	return $css;

}

add_filter('aheto_features_tabs_dynamic_css', 'karma_business_features_single_layout1_dynamic_css', 10, 2);
