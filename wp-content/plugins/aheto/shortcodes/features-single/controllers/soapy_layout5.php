<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'soapy_features_single_layout5');


/**
 * Feature Single
 */

function soapy_features_single_layout5($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('soapy_layout5', [
		'title' => esc_html__('Features Single 52', 'soapy'),
		'image' => $preview_dir . 'soapy_layout5.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading', 'use_description', 't_description'], ['soapy_layout5'], $shortcode);

	$shortcode->add_dependecy('soapy_title', 'template', ['soapy_layout5']);
	$shortcode->add_dependecy('soapy_desc', 'template', ['soapy_layout5']);
	$shortcode->add_dependecy('soapy_year', 'template', 'soapy_layout5');
	$shortcode->add_dependecy('soapy_year_desc', 'template', 'soapy_layout5');
	$shortcode->add_dependecy('soapy_year_use_typo', 'template', 'soapy_layout5');
	$shortcode->add_dependecy('soapy_year_typo', 'template', 'soapy_layout5');
	$shortcode->add_dependecy('soapy_year_typo', 'soapy_year_use_typo', 'true');
	$shortcode->add_dependecy('soapy_year_desc_use_typo', 'template', 'soapy_layout5');
	$shortcode->add_dependecy('soapy_year_desc_typo', 'template', 'soapy_layout5');
	$shortcode->add_dependecy('soapy_year_desc_typo', 'soapy_year_desc_use_typo', 'true');

	$shortcode->add_params([
		'soapy_title'       => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'soapy'),
		],
		'soapy_desc'        => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'soapy'),
		],
		'soapy_year'               => [
			'type'    => 'text',
			'heading' => esc_html__('Year', 'soapy'),
		],
		'soapy_year_desc'          => [
			'type'    => 'text',
			'heading' => esc_html__('Year Description', 'soapy'),
		],
		'soapy_year_use_typo'      => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Year?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_year_typo'          => [
			'type'     => 'typography',
			'group'    => 'Soapy Year Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__year',
		],
		'soapy_year_desc_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Year Description?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_year_desc_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Year Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__year-desc',
		],
	]);
}
function soapy_features_single_layout5_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['soapy_year_use_typo']) && $shortcode->atts['soapy_year_use_typo'] && isset($shortcode->atts['soapy_year_typo']) && !empty($shortcode->atts['soapy_year_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__year'], $shortcode->parse_typography($shortcode->atts['soapy_year_typo']));
	}

	if ( isset($shortcode->atts['soapy_year_desc_use_typo']) && $shortcode->atts['soapy_year_desc_use_typo'] && isset($shortcode->atts['soapy_year_desc_typo']) && !empty($shortcode->atts['soapy_year_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__year-desc'], $shortcode->parse_typography($shortcode->atts['soapy_year_desc_typo']));
	}
	return $css;
}
add_filter('aheto_features_single_dynamic_css', 'soapy_features_single_layout5_dynamic_css', 10, 2);
