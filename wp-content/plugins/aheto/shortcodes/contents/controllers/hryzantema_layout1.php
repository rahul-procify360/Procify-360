<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'hryzantema_contents_layout1');

/**
 * Contents Shortcode
 */

function hryzantema_contents_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout('hryzantema_layout1', [
		'title' => esc_html__('Content 15', 'hryzantema'),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	]);

	aheto_demos_add_dependency(['faqs','first_is_opened','multi_active', 'title_typo','text_typo'], ['hryzantema_layout1'], $shortcode);

	$shortcode->add_dependecy('hryzantema_use_symbol_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_symbol_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_symbol_typo', 'hryzantema_use_symbol_typo', 'true');

	$shortcode->add_params([
		'hryzantema_use_symbol_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for symbol?', 'hryzantema'),
			'grid'    => 3,
		],

		'hryzantema_symbol_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Symbol Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__heading i',
		],
	]);
}

function hryzantema_contents_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_symbol_typo'] ) && $shortcode->atts['hryzantema_use_symbol_typo'] && isset( $shortcode->atts['hryzantema_symbol_typo'] ) && ! empty( $shortcode->atts['hryzantema_symbol_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-contents__heading i'], $shortcode->parse_typography( $shortcode->atts['hryzantema_symbol_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'hryzantema_contents_layout1_dynamic_css', 10, 2 );

