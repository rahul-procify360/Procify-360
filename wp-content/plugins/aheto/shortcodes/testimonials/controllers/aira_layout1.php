<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_testimonials_register', 'aira_testimonials_layout1' );


/**
 * Testimonials Shortcode
 */

function aira_testimonials_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/testimonials/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_bg_text', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_testimonials', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_dark_version', 'template', 'aira_layout1' );

    $shortcode->add_dependecy( 'aira_use_testimonial_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_testimonial_typo', 'aira_use_testimonial_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_bg_text_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_bg_text_typo', 'aira_use_bg_text_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_position_typo', 'template', 'aira_layout1');
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
            'group'    => 'Position text Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__position',
        ],
        'aira_use_bg_text_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Background text?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_bg_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Background text Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__bg-text',
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
        'aira_bg_text'      => [
            'type'    => 'text',
            'heading' => esc_html__( 'Background text', 'aira' ),
            'default' => esc_html__( 'THEY SAY', 'aira' ),
        ],
        'aira_testimonials' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Testimonials Items', 'aira' ),
            'params'  => [
                'aira_image'       => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Display Image', 'aira' ),
                ],
                'aira_name'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Name', 'aira' ),
                    'default' => esc_html__( 'Author name', 'aira' ),
                ],
                'aira_company'     => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Position', 'aira' ),
                    'default' => esc_html__( 'Author position', 'aira' ),
                ],
                'aira_testimonial' => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Testimonial', 'aira' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'aira' ),
                ],
            ],
        ],
    ] );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'include'        => [ 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
        'prefix'         => 'aira_swiper_',
        'dependency'     => [ 'template', [ 'aira_layout1' ] ]
    ] );

}
function aira_testimonials_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['aira_use_testimonial_typo'] ) && ! empty( $shortcode->atts['aira_testimonial_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['aira_testimonial_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_bg_text_typo'] ) && ! empty( $shortcode->atts['aira_bg_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__bg-text'], $shortcode->parse_typography( $shortcode->atts['aira_bg_text_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_testimonial_typo'] ) && ! empty( $shortcode->atts['aira_testimonial_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['aira_testimonial_typo'] ) );
    }
    return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'aira_testimonials_layout1_dynamic_css', 10, 2 );
