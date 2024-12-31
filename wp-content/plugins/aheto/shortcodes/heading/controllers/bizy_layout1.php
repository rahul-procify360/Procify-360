<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_heading_register', 'bizy_heading_layout1' );

/**
 * Heading Shortcode
 */

function bizy_heading_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/heading/previews/';

    $shortcode->add_layout( 'bizy_layout1', [
        'title' => esc_html__( 'Bizy Simple', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'bizy_subtitle', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_dark', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_use_subtitle_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_align_mobile', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_subtitle_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_subtitle_typo', 'bizy_use_subtitle_typo', 'true' );

    aheto_demos_add_dependency( ['text_typo', 'heading', 'alignment', 'source','text_tag', 'use_typo'], [ 'bizy_layout1' ], $shortcode );

    $shortcode->add_params( [
        'bizy_subtitle'          => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Subtitle', 'bizy' ),
            'description' => esc_html__( 'Add some text for Subtitle', 'bizy' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Add some text for Subtitle', 'bizy' ),
        ],
        'bizy_dark' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable dark style?', 'bizy' ),
            'grid'    => 3,
        ],
        'bizy_use_subtitle_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Subtitle?', 'bizy' ),
            'grid'    => 3,
        ],

        'bizy_subtitle_typo' => [
            'type'     => 'typography',
            'group'    => 'Subtitle Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
        ],

        'bizy_align_mobile' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for mobile', 'bizy' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
        ],

    ] );

}

function bizy_heading_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['bizy_use_subtitle_typo'] ) && ! empty( $shortcode->atts['bizy_subtitle_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography( $shortcode->atts['bizy_subtitle_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'bizy_heading_layout1_dynamic_css', 10, 2 );

