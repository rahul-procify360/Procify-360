<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_features-single_register', 'aira_features_single_layout7' );

/**
 * Features Single Shortcode
 */

function aira_features_single_layout7( $shortcode ) {

    $theme_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'aira_layout7', [
        'title' => esc_html__( 'Aira Vertical', 'aira' ),
        'image' => $theme_dir . 'aira_layout7.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_use_title_typo', 'template', 'aira_layout6' );
    $shortcode->add_dependecy( 'aira_title_typo', 'aira_use_title_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_description_typo', 'template', 'aira_layout6');
    $shortcode->add_dependecy( 'aira_description_typo', 'aira_use_description_typo', 'true' );
    $shortcode->add_dependecy( 'aira_link_url', 'template', ['aira_layout7']);

    aheto_demos_add_dependency( ['s_heading','s_image','s_description'], ['aira_layout7'], $shortcode );

    $shortcode->add_params( [
        'aira_link_url'      => [
            'type'    => 'text',
            'heading' => esc_html__( 'Link URL', 'aira' ),
            'default' => '#'
        ],
        'aira_use_title_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for heading?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_title_typo' => [
            'type' => 'typography',
            'group' => 'Heading Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-block__title',
        ],
        'aira_use_description_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_description_typo' => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-block__description',
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'dependency' => ['template', ['aira_layout7']]
    ]);

}

function aira_features_single_layout7_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_title_typo'] ) && ! empty( $shortcode->atts['aira_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-features-block__title'], $shortcode->parse_typography( $shortcode->atts['aira_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_description_typo'] ) && ! empty( $shortcode->atts['aira_description_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-features-block__description'], $shortcode->parse_typography( $shortcode->atts['aira_description_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'aira_features_single_layout7_dynamic_css', 10, 2 );