<?php

use Aheto\Helper;

add_action('aheto_before_aheto_blockquote_register', 'famulus_blockquote_layout1');

/**
 *  Banner Slider
 */

function famulus_blockquote_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/blockquote/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Blockquote 1', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	aheto_demos_add_dependency(['quote', 'use_quote',  'author', 'qoute_tag', 'max_width', 'quote_spacing', 't_quote'], ['famulus_layout1'], $shortcode);

	$shortcode->add_dependecy('famulus_date', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_use_typo_name', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_name', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_name', 'famulus_use_typo_name', 'true');
	$shortcode->add_dependecy('famulus_use_typo_date', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_date', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_date', 'famulus_use_typo_date', 'true');

	$shortcode->add_params([
		'advanced'     => true,
		'famulus_date' => [
			'type'    => 'text',
			'heading' => esc_html__('Date', 'famulus'),
		],
		'famulus_use_typo_name'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for author?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_name' => [
			'type'     => 'typography',
			'group'    => 'Famulus Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-quote__author',
		],
		'famulus_use_typo_date'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for date?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_date' => [
			'type'     => 'typography',
			'group'    => 'Famulus Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-quote__date',
		],
	]);

}
function famulus_aheto_blockquote_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_typo_name']) && $shortcode->atts['famulus_use_typo_name'] && isset($shortcode->atts['famulus_text_typo_name']) && !empty($shortcode->atts['famulus_text_typo_name']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__author'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_name']));
	}
	if ( isset($shortcode->atts['famulus_use_typo_date']) && $shortcode->atts['famulus_use_typo_date'] && isset($shortcode->atts['famulus_text_typo_date']) && !empty($shortcode->atts['famulus_text_typo_date']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__date'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_date']));
	}
	return $css;
}

add_filter('aheto_blockquote_dynamic_css', 'famulus_aheto_blockquote_layout1_dynamic_css', 10, 2);