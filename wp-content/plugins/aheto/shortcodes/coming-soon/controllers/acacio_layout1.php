<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_coming-soon_register', 'acacio_coming_soon_layout1' );

/**
 *  Banner Slider
 */

function acacio_coming_soon_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/coming-soon/previews/';

    $shortcode->add_layout( 'acacio_layout1', [
        'title' => esc_html__( 'Coming Soon 1', 'acacio' ),
        'image' => $preview_dir . 'acacio_layout1.jpg',
    ] );

    aheto_demos_add_dependency( ['light', 'time', 'days_desktop', 'days_mobile', 'hours_desktop', 'hours_mobile', 'mins_desktop', 'mins_mobile', 'secs_desktop', 'secs_mobile' ], [ 'acacio_layout1' ], $shortcode );

    $shortcode->add_dependecy('acacio_use_units_text_typo', 'template', 'acacio_layout1');
    $shortcode->add_dependecy('acacio_units_text_typo', 'template', 'acacio_layout1');
    $shortcode->add_dependecy('acacio_units_text_typo', 'acacio_use_units_text_typo', 'true');

    $shortcode->add_dependecy('acacio_use_units_number_typo', 'template', 'acacio_layout1');
    $shortcode->add_dependecy('acacio_units_number_typo', 'template', 'acacio_layout1');
    $shortcode->add_dependecy('acacio_units_number_typo', 'acacio_use_units_number_typo', 'true');

    $shortcode->add_dependecy('acacio_use_units_dots_typo', 'template', 'acacio_layout1');
    $shortcode->add_dependecy('acacio_units_dots_typo', 'template', 'acacio_layout1');
    $shortcode->add_dependecy('acacio_units_dots_typo', 'acacio_use_units_dots_typo', 'true');

    $shortcode->add_params([
        'acacio_use_units_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for caption?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_units_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Caption Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-coming-soon__caption',
        ],
        'acacio_use_units_number_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for numbers?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_units_number_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Numbers Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-coming-soon__number',
        ],
        'acacio_use_units_dots_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for dots?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_units_dots_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Dots Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
        ],
    ]);
}


function acacio_coming_soon_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_units_text_typo'] ) && ! empty( $shortcode->atts['acacio_units_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-coming-soon__caption'], $shortcode->parse_typography( $shortcode->atts['acacio_units_text_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_units_number_typo'] ) && ! empty( $shortcode->atts['acacio_units_number_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-coming-soon__number'], $shortcode->parse_typography( $shortcode->atts['acacio_units_number_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_units_dots_typo'] ) && ! empty( $shortcode->atts['acacio_units_dots_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography( $shortcode->atts['acacio_units_dots_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_coming-soon_dynamic_css', 'acacio_coming_soon_layout1_dynamic_css', 10, 2 );
