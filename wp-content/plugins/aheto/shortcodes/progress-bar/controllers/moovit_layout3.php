<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'moovit_progress_bar_layout3' );
/**
 * Progress Bar Shortcode
 */

function moovit_progress_bar_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'moovit_layout3', [
		'title' => esc_html__( 'Progress Bar 13', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout3.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_line_color', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_active_color', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_use_text_typo', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_text_typo', 'template', 'moovit_layout3' );
	$shortcode->add_dependecy( 'moovit_text_typo', 'moovit_use_text_typo', 'true' );

	aheto_demos_add_dependency( ['percentage', 'heading'], [ 'moovit_layout3' ], $shortcode );

	$shortcode->add_params( [
		'moovit_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for heading?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Heading Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__title, {{WRAPPER}} .aheto-progress__bar-perc',
		],
		'moovit_line_color'   => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Line color', 'moovit' ),
			'grid'      => 6,
			'default'   => '#fff',
			'selectors' => [
				'{{WRAPPER}} .aheto-progress__bar' => 'background: {{VALUE}}',
			],
		],
		'moovit_active_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Active line color', 'moovit' ),
			'grid'      => 6,
			'default'   => '#fff',
			'selectors' => [
				'{{WRAPPER}} .aheto-progress__bar-val'         => 'background: {{VALUE}}',
				'{{WRAPPER}} .aheto-progress__bar-val::before' => 'background: {{VALUE}}',
			],
		],
	] );
}

function moovit_progress_bar_layout3_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_text_typo'] ) && ! empty( $shortcode->atts['moovit_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography( $shortcode->atts['moovit_text_typo'] ) );
		\aheto_add_props( $css['global']['%1$s .aheto-progress__bar-perc'], $shortcode->parse_typography( $shortcode->atts['moovit_text_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['moovit_line_color'] ) ) {
		$color                                                    = Sanitize::color( $shortcode->atts['moovit_line_color'] );
		$css['global']['%1$s .aheto-progress__bar']['background'] = $color;
	}

	if ( ! empty( $shortcode->atts['moovit_active_color'] ) ) {
		$color                                                                = Sanitize::color( $shortcode->atts['moovit_active_color'] );
		$css['global']['%1$s .aheto-progress__bar-val']['background']         = $color;
		$css['global']['%1$s .aheto-progress__bar-val::before']['background'] = $color;
	}

	return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'moovit_progress_bar_layout3_dynamic_css', 10, 2 );