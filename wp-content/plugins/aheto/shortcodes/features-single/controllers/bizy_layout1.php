<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'bizy_features_single_layout1' );

/**
 * Features Single
 */

function bizy_features_single_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'bizy_layout1', [
        'title' => esc_html__( 'Bizy Modern', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout1.jpg',
    ] );

    aheto_demos_add_dependency( ['s_heading', 't_heading', 'use_heading', 's_description', 's_image', 't_description', 'use_description', 'button' ], [ 'bizy_layout1'], $shortcode );

    $shortcode->add_dependecy( 'bizy_subtitle', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_use_subtitle', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_t_subtitle', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_t_subtitle', 'bizy_use_subtitle', 'true' );

    $shortcode->add_params( [
        'bizy_subtitle'   => [
            'type'    => 'textarea',
            'heading' => esc_html__('Subtitle', 'aheto'),
            'grid'    => 9,
            'default' => esc_html__('Please add your subtitle text.', 'aheto')
        ],
        'bizy_use_subtitle' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for subtitle?', 'aheto'),
            'grid'    => 3,
        ],
        'bizy_t_subtitle'    => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-content-block__info-text',
        ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Bizy Images Size', 'aheto' ),
        'prefix'     => 'bizy_',
        'dependency' => ['template', ['bizy_layout1']]
    ]);

    \Aheto\Params::add_button_params( $shortcode, [
        'group'      => esc_html__( 'Bizy Button Settings', 'aheto' ),
        'prefix' => 'bizy_',
        'icons'      => true,
        'dependency' => ['template', [ 'bizy_layout1'] ]
    ]);
}


function bizy_features_single_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['bizy_use_subtitle'] ) && ! empty( $shortcode->atts['bizy_t_subtitle'] ) ) {
        \aheto_add_props( $css['global']['%1$s  .aheto-content-block__info-text'], $shortcode->parse_typography( $shortcode->atts['bizy_t_subtitle'] ) );
    }

    return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'bizy_features_single_layout1_dynamic_css', 10, 2 );