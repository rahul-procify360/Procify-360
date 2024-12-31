<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'hryzantema_list_layout3');

/**
 * HR Consult List
 */

function hryzantema_list_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'hryzantema_layout3', [
		'title' => esc_html__( 'List 7', 'hryzantema' ),
		'image' => $preview_dir . 'acacio_layout3.jpg',
	] );
	aheto_demos_add_dependency('lists', ['hryzantema_layout3'], $shortcode);
	$shortcode->add_dependecy( 'hryzantema_use_list_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_list_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_list_typo', 'hryzantema_use_list_typo', 'true' );

	$shortcode->add_params( [
		'hryzantema_use_list_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for list?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_list_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema List Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} li',
		],
	] );
}
function hryzantema_list_layout3_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_list_typo'] ) && $shortcode->atts['hryzantema_use_list_typo'] && isset( $shortcode->atts['hryzantema_list_typo'] ) && ! empty( $shortcode->atts['hryzantema_list_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s li'], $shortcode->parse_typography( $shortcode->atts['hryzantema_list_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'hryzantema_list_layout3_dynamic_css', 10, 2 );
