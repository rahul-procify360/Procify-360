<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_social-networks_register', 'aira_social_networks_layout1' );



/**
 * Social Networks
 */
function aira_social_networks_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/social-networks/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_color', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_hovercolor', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_use_text_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_text_typo', 'aira_use_text_typo', 'true');

    aheto_demos_add_dependency(['networks','socials_align_mob','socials_align','size'], ['aira_layout1'], $shortcode);


    $shortcode->add_params( [
        'aira_use_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Social name?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Social name Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-socials__name',
        ],

        'aira_color'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Color', 'aira' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-socials__link' => 'color: {{VALUE}}' ],
        ],
        'aira_hovercolor'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Color on hover', 'aira' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-socials__link:hover' => 'color: {{VALUE}}' ],
        ],
    ] );
}

function aira_social_networks_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_text_typo'] ) && ! empty( $shortcode->atts['aira_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-socials__name'], $shortcode->parse_typography( $shortcode->atts['aira_text_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['aira_color'] );
        $css['global']['%1$s .aheto-socials__link']['color'] = $color;
    }
    if ( ! empty( $shortcode->atts['aira_hovercolor'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['aira_hovercolor'] );
        $css['global']['%1$s .aheto-socials__link:hover']['color'] = $color;
    }
    return $css;
}

add_filter( 'aheto_social_networks_dynamic_css', 'aira_social_networks_layout1_dynamic_css', 10, 2 );
