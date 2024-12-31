<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_coming-soon_register', 'noize_coming_soon_layout1' );

/**
 * Coming Soon Shortcode
 */
function noize_coming_soon_layout1( $shortcode ) {
    $preview_dir = '//assets.aheto.co/coming-soon/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Coming Soon 5', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    aheto_demos_add_dependency( ['time', 'days_desktop', 'days_mobile', 'hours_desktop', 'hours_mobile', 'mins_desktop', 'mins_mobile', 'secs_desktop', 'secs_mobile', 'use_typo_numbers', 'typo_numbers', 'use_typo_caption', 'typo_caption' ], [ 'noize_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'noize_use_typo_dots', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_typo_dots', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_typo_dots', 'noize_use_typo_dots', 'true' );

    $shortcode->add_params( [
        'noize_use_typo_dots'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font dots?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_typo_dots'   => [
            'type'     => 'typography',
            'group'    => 'Noize Dots Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
        ],
    ] );
}

function noize_coming_soon_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo_dots'] ) && ! empty( $shortcode->atts['noize_typo_dots'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography( $shortcode->atts['noize_typo_dots'] ) );
    }

    return $css;
}

add_filter( 'aheto_coming_soon_dynamic_css', 'noize_coming_soon_layout1_dynamic_css', 10, 2 );