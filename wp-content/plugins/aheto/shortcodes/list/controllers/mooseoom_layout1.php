<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'mooseoom_list_layout1');

/**
 * List
 */

function mooseoom_list_layout1($shortcode)
{
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout('mooseoom_layout1', [
		'title' => esc_html__('List 8', 'mooseoom'),
		'image' => $dir . 'mooseoom_layout1.jpg',
	]);

	$shortcode->add_dependecy('mooseoom_links', 'template', ['mooseoom_layout1']);
	$shortcode->add_dependecy('mooseoom_use_lists_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_lists_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_lists_typo', 'mooseoom_use_lists_typo', 'true');

	$shortcode->add_params([
		'mooseoom_links' => [
			'type'    => 'group',
			'heading' => esc_html__('Link Items', 'mooseoom'),
			'params'  => [
				'mooseoom_text'        => [
					'type'    => 'text',
					'heading' => esc_html__('Text', 'mooseoom'),
					'default' => esc_html__('Link text', 'mooseoom'),
				],
				'mooseoom_url'        => [
					'type'    => 'text',
					'heading' => esc_html__('URL', 'mooseoom'),
					'default' => esc_html__('https://', 'mooseoom'),
				],
			],
		],
		'mooseoom_use_lists_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for list?', 'mooseoom'),
			'grid'    => 3,
		],

		'mooseoom_lists_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom List Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-list--mooseoom-links li a',
		],
	]);
}
function mooseoom_list_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['mooseoom_use_list_typo'] ) && ! empty( $shortcode->atts['mooseoom_list_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s li'], $shortcode->parse_typography( $shortcode->atts['mooseoom_list_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'mooseoom_list_layout1_dynamic_css', 10, 2 );