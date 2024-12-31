<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'karma_business_progress_bar_layout1');

/**
 * Progress Bar Shortcode
 */

function karma_business_progress_bar_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('karma_business_layout1', [
		'title' => esc_html__('Progress Bar 8', 'business'),
		'image' => $preview_dir . 'karma_business_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_business_use_number_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_number_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_number_typo', 'karma_business_use_number_typo', 'true');
	
	$shortcode->add_dependecy('karma_business_use_title_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_title_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_title_typo', 'karma_business_use_title_typo', 'true');
	
	$shortcode->add_dependecy('karma_business_use_desc_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_desc_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_desc_typo', 'karma_business_use_desc_typo', 'true');
	
	aheto_demos_add_dependency( [ 'percentage', 'heading', 'description' ], ['karma_business_layout1'], $shortcode);

	$shortcode->add_params([

		'karma_business_use_number_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Business Number?', 'business'),
			'grid'    => 3,
		],
		'karma_business_number_typo'     => [
			'type'     => 'typography',
			'group'    => 'Business Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__chart-symbol',
		],
		
		'karma_business_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Business Title?', 'business'),
			'grid'    => 3,
		],
		'karma_business_title_typo'     => [
			'type'     => 'typography',
			'group'    => 'Business Tistle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__title',
		],
		
		'karma_business_use_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Business Desc?', 'business'),
			'grid'    => 3,
		],
		'karma_business_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Business Desc Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__desc',
		],

	]);


}

function karma_business_progress_bar_layout1_dynamic_css($css, $shortcode) {

	if ( !empty($shortcode->atts['karma_business_use_number_typo']) && !empty($shortcode->atts['karma_business_number_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__chart-symbol'], $shortcode->parse_typography($shortcode->atts['karma_business_number_typo']));
	}
	
	if ( !empty($shortcode->atts['karma_business_use_title_typo']) && !empty($shortcode->atts['karma_business_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['karma_business_title_typo']));
	}
	
	if ( !empty($shortcode->atts['karma_business_use_desc_typo']) && !empty($shortcode->atts['karma_business_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-progress__desc'], $shortcode->parse_typography($shortcode->atts['karma_business_desc_typo']));
	}
	
	return $css;

}

add_filter('aheto_progress_bar_dynamic_css', 'karma_business_progress_bar_layout1_dynamic_css', 10, 2);
