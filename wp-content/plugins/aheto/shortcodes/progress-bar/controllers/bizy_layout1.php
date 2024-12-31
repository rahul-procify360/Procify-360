<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_progress-bar_register', 'bizy_progress_bar_layout1' );


/**
 * Progress Bar
 */

function bizy_progress_bar_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout( 'bizy_layout1', [
        'title' => esc_html__( 'Bizy Simple', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'bizy_align', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_t_align', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_m_align', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_use_bg_number_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_bg_number_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_bg_number_typo', 'bizy_use_bg_number_typo', 'true' );
    $shortcode->add_dependecy( 'bizy_use_number_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_number_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_number_typo', 'bizy_use_number_typo', 'true' );
    $shortcode->add_dependecy( 'bizy_use_descr_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_descr_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_descr_typo', 'bizy_use_descr_typo', 'true' );

    aheto_demos_add_dependency( ['percentage', 'description'], [ 'bizy_layout1' ], $shortcode );

    $shortcode->add_params( [
        'bizy_use_number_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for numbers?', 'bizy' ),
            'grid'    => 3,
        ],
        'bizy_number_typo'     => [
            'type'     => 'typography',
            'group'    => 'Bizy Numbers Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number',
        ],
        'bizy_use_bg_number_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for background numbers?', 'bizy' ),
            'grid'    => 3,
            'label_block'       => true,
        ],
        'bizy_bg_number_typo'     => [
            'type'     => 'typography',
            'group'    => 'Bizy Background Numbers Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number-bg',
        ],
        'bizy_use_descr_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'bizy' ),
            'grid'    => 3,
        ],
        'bizy_descr_typo'     => [
            'type'     => 'typography',
            'group'    => 'Bizy Description Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__desc',
        ],
        'bizy_align'             => [
            'type'    => 'select',
            'heading' => esc_html__( 'Desktop Align', 'bizy' ),
            'options' => \Aheto\Helper::choices_alignment(),
        ],
        'bizy_t_align'             => [
            'type'    => 'select',
            'heading' => esc_html__( 'Tablet Align', 'bizy' ),
            'options' => \Aheto\Helper::choices_alignment(),
        ],
        'bizy_m_align'             => [
            'type'    => 'select',
            'heading' => esc_html__( 'Mobile Align', 'bizy' ),
            'options' => \Aheto\Helper::choices_alignment(),
        ],
    ] );
}

function bizy_progress_bar_layout1_dynamic_css( $css, $shortcode ) {

    if (isset( $shortcode->atts['bizy_use_bg_number_typo'] ) && $shortcode->atts['bizy_use_bg_number_typo'] && isset($shortcode->atts['bizy_bg_number_typo']) && ! empty( $shortcode->atts['bizy_bg_number_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-counter__number-bg'], $shortcode->parse_typography( $shortcode->atts['bizy_bg_number_typo'] ) );
    }

    if (isset( $shortcode->atts['bizy_use_number_typo'] ) && $shortcode->atts['bizy_use_number_typo'] && isset($shortcode->atts['bizy_number_typo']) && ! empty( $shortcode->atts['bizy_number_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography( $shortcode->atts['bizy_number_typo'] ) );
    }

    if (isset( $shortcode->atts['bizy_use_descr_typo'] ) && $shortcode->atts['bizy_use_descr_typo'] && isset($shortcode->atts['bizy_descr_typo']) && ! empty( $shortcode->atts['bizy_descr_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-counter__desc'], $shortcode->parse_typography( $shortcode->atts['bizy_descr_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'bizy_progress_bar_layout1_dynamic_css', 10, 2 );