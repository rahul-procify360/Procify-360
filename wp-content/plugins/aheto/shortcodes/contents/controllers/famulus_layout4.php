<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'famulus_contents_layout4');


/**
 * Contents
 */

function famulus_contents_layout4($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';
	$shortcode->add_layout('famulus_layout4', [
		'title' => esc_html__('Content 9', 'famulus'),
		'image' => $preview_dir . 'famulus_layout4.jpg',
	]);
	aheto_demos_add_dependency(['first_is_opened', 'multi_active'], ['famulus_layout4'], $shortcode);

	$shortcode->add_dependecy('famulus_use_typo_type', 'template', 'famulus_layout4');
	$shortcode->add_dependecy('famulus_text_typo_type', 'template', 'famulus_layout4');
	$shortcode->add_dependecy('famulus_text_typo_type', 'famulus_use_typo_type', 'true');
	$shortcode->add_dependecy('famulus_faq_modern', 'template', 'famulus_layout4');

	$shortcode->add_params([

		'famulus_faq_modern' => [
			'type'    => 'group',
			'heading' => esc_html__('Faqs', 'famulus'),
			'params'  => [
				'famulus_item_title' => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'famulus'),
				],
				'famulus_item_type'  => [
					'type'    => 'text',
					'heading' => esc_html__('Type', 'famulus'),
				],
				'famulus_item_desc'  => [
					'type'    => 'textarea',
					'heading' => esc_html__('Description', 'famulus'),
				],
			]
		],

		'famulus_use_typo_type'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for type?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_type' => [
			'type'     => 'typography',
			'group'    => 'Famulus Type Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__type',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'famulus_faq_btn_',
		'icons'  => true,
	], 'famulus_faq_modern');

}

function famulus_contents_layout4_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_typo_type']) && $shortcode->atts['famulus_use_typo_type'] && isset($shortcode->atts['famulus_text_typo_type']) && !empty($shortcode->atts['famulus_text_typo_type']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-contents__type'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_type']));
	}
	return $css;
}

add_filter('aheto_contents_dynamic_css', 'famulus_contents_layout4_dynamic_css', 10, 2);