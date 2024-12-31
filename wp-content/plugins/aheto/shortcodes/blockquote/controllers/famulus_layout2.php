<?php

use Aheto\Helper;

add_action('aheto_before_aheto_blockquote_register', 'famulus_blockquote_layout2');

/**
 *  Banner Slider
 */

function famulus_blockquote_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/blockquote/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Blockquote 2', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	aheto_demos_add_dependency(['quote', 'use_quote', 'author', 'qoute_tag', 'max_width', 'quote_spacing', 't_quote' ], ['famulus_layout2'], $shortcode);

	$shortcode->add_dependecy('famulus_use_typo_position', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_position', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_position', 'famulus_use_typo_position', 'true');
	$shortcode->add_dependecy('famulus_position', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_use_typo_name', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_name', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_text_typo_name', 'famulus_use_typo_name', 'true');
	$shortcode->add_params([
		'advanced'         => true,
		'famulus_position' => [
			'type'    => 'text',
			'heading' => esc_html__('Position', 'famulus'),
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
		'famulus_use_typo_position'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_position' => [
			'type'     => 'typography',
			'group'    => 'Famulus Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-quote__position',
		],
	]);

}
function famulus_blockquote_layout2_dynamic_css($css, $shortcode) {
	
	if ( isset($shortcode->atts['famulus_use_typo_position']) && $shortcode->atts['famulus_use_typo_position'] && isset($shortcode->atts['famulus_text_typo_position'])  && !empty($shortcode->atts['famulus_text_typo_position']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__position'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_position']));
	}
	if ( isset($shortcode->atts['famulus_use_typo_name']) && $shortcode->atts['famulus_use_typo_name'] &&  isset($shortcode->atts['famulus_text_typo_name']) &&  !empty($shortcode->atts['famulus_text_typo_name']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__author'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_name']));
	}
	return $css;
}

add_filter('aheto_blockquote_dynamic_css', 'famulus_blockquote_layout2_dynamic_css', 10, 2);