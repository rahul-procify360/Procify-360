<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_title-bar_register', 'acacio_title_bar_layout1' );

/**
 * Title Bar
 */

function acacio_title_bar_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/title-bar/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Title Bar 1', 'acacio' ),
		'image' => $dir . 'acacio_layout1.jpg',
	] );


	aheto_demos_add_dependency( ['source', 'title', 'title_tag', 'use_title_typo', 'title_typo', 'searchform', 'sf_button', 'sf_placeholder'], [ 'acacio_layout1' ], $shortcode );

    $shortcode->depedency['title']['source'][]  = 'acacio_layout1';

	$shortcode->add_dependecy( 'acacio_use_text_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_text_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_text_typo', 'acacio_use_text_typo', 'true' );

	$shortcode->add_params( [
		'acacio_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for input text?', 'acacio' ),
			'grid'    => 3,
		],
		'acacio_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Acacio Text Input Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-titlebar__input form',
		],
	] );
}

function acacio_title_bar_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['acacio_use_text_typo'] ) && ! empty( $shortcode->atts['acacio_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-titlebar__input form'], $shortcode->parse_typography( $shortcode->atts['acacio_text_typo'] ) );
	}


	return $css;
}

add_filter( 'aheto_title_bar_dynamic_css', 'acacio_title_bar_layout1_dynamic_css', 10, 2 );