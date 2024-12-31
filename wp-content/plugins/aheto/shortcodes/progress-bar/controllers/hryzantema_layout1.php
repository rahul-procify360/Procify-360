<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'hryzantema_progress_bar_layout1');

/**
 * Progress bar shortcode
 */

function hryzantema_progress_bar_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Progress Bar 6', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_demos_add_dependency(['heading','percentage'], ['hryzantema_layout1'], $shortcode);
	$shortcode->add_dependecy( 'hryzantema_line_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_active_color', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_use_text_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'hryzantema_use_text_typo', 'true' );


	$shortcode->add_params( [
		'hryzantema_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for text?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__title, {{WRAPPER}} .aheto-progress__bar-perc',
		],
		'hryzantema_line_color'   => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Line color', 'hryzantema' ),
			'grid'      => 6,
			'default'   => '#fff',
			'selectors' => [
				'{{WRAPPER}} .aheto-progress__bar' => 'background: {{VALUE}}',
			],
		],
		'hryzantema_active_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Active line color', 'hryzantema' ),
			'grid'      => 6,
			'default'   => '#fff',
			'selectors' => [
				'{{WRAPPER}} .aheto-progress__bar-val'         => 'background: {{VALUE}}',
				'{{WRAPPER}} .aheto-progress__bar-val::before' => 'background: {{VALUE}}',
			],
		],
	] );
}

function hryzantema_progress_bar_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_text_typo'] ) && $shortcode->atts['hryzantema_use_text_typo'] && isset( $shortcode->atts['hryzantema_text_typo'] ) && ! empty( $shortcode->atts['hryzantema_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography( $shortcode->atts['hryzantema_text_typo'] ) );
		\aheto_add_props( $css['global']['%1$s .aheto-progress__bar-perc'], $shortcode->parse_typography( $shortcode->atts['hryzantema_text_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['hryzantema_line_color'] ) ) {
		$color                                                    = Sanitize::color( $shortcode->atts['hryzantema_line_color'] );
		$css['global']['%1$s .aheto-progress__bar']['background'] = $color;
	}

	if ( ! empty( $shortcode->atts['hryzantema_active_color'] ) ) {
		$color                                                                = Sanitize::color( $shortcode->atts['hryzantema_active_color'] );
		$css['global']['%1$s .aheto-progress__bar-val']['background']         = $color;
		$css['global']['%1$s .aheto-progress__bar-val::before']['background'] = $color;
	}

	return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'hryzantema_progress_bar_layout1_dynamic_css', 10, 2 );
