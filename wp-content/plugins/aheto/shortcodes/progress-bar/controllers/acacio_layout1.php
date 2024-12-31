<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'acacio_progress_bar_layout1' );
/**
 * Progress Bar Shortcode
 */

function acacio_progress_bar_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Progress Bar 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );
	

    aheto_demos_add_dependency( ['percentage', 'heading'], [ 'acacio_layout1' ], $shortcode );

    //	Acacio Inline Progress Bar
    $shortcode->add_dependecy( 'acacio_line_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_active_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_active_circle', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_use_text_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_text_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_text_typo', 'acacio_use_text_typo', 'true' );


    $shortcode->add_params([
        'acacio_use_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for heading?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Heading Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title, {{WRAPPER}} .aheto-progress__bar-perc',
        ],
        'acacio_line_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Line color', 'acacio' ),
            'grid'      => 6,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__bar' => 'background: {{VALUE}}',
            ],
        ],
        'acacio_active_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Active line color', 'acacio' ),
            'grid'      => 6,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__bar-val'         => 'background: {{VALUE}}',
                '{{WRAPPER}} .aheto-progress__bar-val::before' => 'background: {{VALUE}}',
            ],
        ],
        'acacio_active_circle' => [
            'type'      => 'switch',
            'heading'   => esc_html__( 'Remove circle on active part?', 'acacio' ),
            'grid'      => 3,
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__bar-val::before' => 'display: none',
            ],
        ],
    ]);
}

function acacio_progress_bar_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio__use_text_typo'] ) && ! empty( $shortcode->atts['acacio__text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography( $shortcode->atts['acacio__text_typo'] ) );
        \aheto_add_props( $css['global']['%1$s .aheto-progress__bar-perc'], $shortcode->parse_typography( $shortcode->atts['acacio__text_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['acacio__line_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['acacio__line_color'] );
        $css['global']['%1$s .aheto-progress__bar']['background'] = $color;
    }

    if ( ! empty( $shortcode->atts['acacio__active_color'] ) ) {
        $color                                                                = Sanitize::color( $shortcode->atts['acacio__active_color'] );
        $css['global']['%1$s .aheto-progress__bar-val']['background']         = $color;
        $css['global']['%1$s .aheto-progress__bar-val::before']['background'] = $color;
    }

    return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'acacio_progress_bar_layout1_dynamic_css', 10, 2 );
