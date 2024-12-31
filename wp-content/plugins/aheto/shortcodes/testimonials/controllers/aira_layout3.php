<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_testimonials_register', 'aira_testimonials_layout3' );


/**
 * Testimonials Shortcode
 */

function aira_testimonials_layout3( $shortcode ) {

    $theme_dir = '//assets.aheto.co/testimonials/previews/';

    $shortcode->add_layout( 'aira_layout3', [
        'title' => esc_html__( 'Aira Minimal', 'aira' ),
        'image' => $theme_dir . 'aira_layout3.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_single_name', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_position', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_testimonial_single', 'template', 'aira_layout3' );

    $shortcode->add_dependecy( 'aira_use_testimonial_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_testimonial_typo', 'aira_use_testimonial_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_name_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_name_typo', 'aira_use_name_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_position_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_position_typo', 'aira_use_position_typo', 'true' );

    $shortcode->add_params( [
        'aira_use_position_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Position?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_position_typo' => [
            'type'     => 'typography',
            'group'    => 'Position Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__position',
        ],
        'aira_use_testimonial_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Testimonial?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_testimonial_typo' => [
            'type'     => 'typography',
            'group'    => 'Testimonial Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__text',
        ],
        'aira_testimonial_single' => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Testimonial', 'aira' ),
            'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'aira' ),
        ],
        'aira_position'     => [
            'type'    => 'text',
            'heading' => esc_html__( 'Position', 'aira' ),
            'default' => esc_html__( 'Author position', 'aira' ),
        ],
        'aira_single_name'        => [
            'type'    => 'text',
            'heading' => esc_html__( 'Name', 'aira' ),
            'default' => esc_html__( 'Author name', 'aira' ),
        ],
        'aira_use_name_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Name?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_name_typo' => [
            'type'     => 'typography',
            'group'    => 'Name Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__name',
        ],
    ] );
}

function aira_testimonials_layout3_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_testimonial_typo'] ) && ! empty( $shortcode->atts['aira_testimonial_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['aira_testimonial_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_name_typo'] ) && ! empty( $shortcode->atts['aira_name_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography( $shortcode->atts['aira_name_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_position_typo'] ) && ! empty( $shortcode->atts['aira_position_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography( $shortcode->atts['aira_position_typo'] ) );
    }
    return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'aira_testimonials_layout3_dynamic_css', 10, 2 );
