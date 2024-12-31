<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'outsourceo_contents_layout4' );

/**
 * Contents Shortcode
 */

function outsourceo_contents_layout4( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'outsourceo_layout4', [
		'title' => esc_html__( 'Content 28', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout4.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_simple_text', 'template', 'outsourceo_layout4' );
	$shortcode->add_dependecy( 'outsourceo_use_typo_simple_text', 'template', 'outsourceo_layout4' );
	$shortcode->add_dependecy( 'outsourceo_text_typo_simple_text', 'template', 'outsourceo_layout4' );
	$shortcode->add_dependecy( 'outsourceo_text_typo_simple_text', 'outsourceo_use_typo_simple_text', 'true' );


	$shortcode->add_params( [
		'outsourceo_simple_text'    => [
			'type'    => 'wysiwyg',
			'heading' => esc_html__( 'Text Simple', 'outsourceo' ),
			'default' => esc_html__( 'Put your text...', 'outsourceo' ),
		],
		'outsourceo_use_typo_simple_text'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for simple text?', 'outsourceo' ),
			'grid'    => 6,
		],
		'outsourceo_text_typo_simple_text'   => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Simple Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content--outsourceo-simple *',
		],
	] );

}


function outsourceo_contents_layout4_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_typo_simple_text'] ) && ! empty( $shortcode->atts['outsourceo_text_typo_simple_text'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-content--outsourceo-simple *'], $shortcode->parse_typography( $shortcode->atts['outsourceo_text_typo_simple_text'] ) );
	}

	return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'outsourceo_contents_layout4_shortcode_dynamic_css', 10, 2 );