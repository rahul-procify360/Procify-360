<?php

use Aheto\Helper;

add_action('aheto_before_aheto_blockquote_register', 'soapy_blockquote_layout1');

/**
 *  Banner Slider
 */

function soapy_blockquote_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/blockquote/previews/';


	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Blockquote 6', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['qoute_tag', 'max_width'], ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_quote', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_author', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_position', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_position_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_position_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_position_typo', 'soapy_position_use_typo', 'true');
	$shortcode->add_dependecy('soapy_quote_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_quote_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_quote_typo', 'soapy_quote_use_typo', 'true');
	$shortcode->add_dependecy('soapy_author_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_author_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_author_typo', 'soapy_author_use_typo', 'true');

	$shortcode->add_params([
		'soapy_quote'    => [
			'type'    => 'textarea',
			'heading' => esc_html__('Quote', 'soapy'),
		],
		'soapy_author'   => [
			'type'    => 'text',
			'heading' => esc_html__('Author', 'soapy'),
		],
		'soapy_position' => [
			'type'    => 'text',
			'heading' => esc_html__('Position', 'soapy'),
		],


		'soapy_position_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_position_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-quote__position',
		],
		'soapy_quote_use_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for quote?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_quote_typo'        => [
			'type'     => 'typography',
			'group'    => 'Soapy Quote Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-quote__quote',
		],
		'soapy_author_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for author?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_author_typo'       => [
			'type'     => 'typography',
			'group'    => 'Soapy Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-quote__author',
		],
	]);

}

function soapy_blockquote_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['soapy_quote_use_typo']) && $shortcode->atts['soapy_quote_use_typo'] && isset($shortcode->atts['soapy_quote_typo']) && !empty($shortcode->atts['soapy_quote_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__quote'], $shortcode->parse_typography($shortcode->atts['soapy_quote_typo']));
	}
	if ( isset($shortcode->atts['soapy_author_use_typo']) && $shortcode->atts['soapy_author_use_typo'] && isset($shortcode->atts['soapy_author_typo']) && !empty($shortcode->atts['soapy_author_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__author'], $shortcode->parse_typography($shortcode->atts['soapy_author_typo']));
	}
	if ( isset($shortcode->atts['soapy_position_use_typo']) && $shortcode->atts['soapy_position_use_typo'] && isset($shortcode->atts['soapy_position_typo'])  && !empty($shortcode->atts['soapy_position_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__position'], $shortcode->parse_typography($shortcode->atts['soapy_position_typo']));
	}

	return $css;
}

add_filter('aheto_blockquote_dynamic_css', 'soapy_blockquote_layout1_dynamic_css', 10, 2);

