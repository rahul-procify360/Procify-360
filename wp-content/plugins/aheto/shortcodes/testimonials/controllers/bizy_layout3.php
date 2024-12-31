<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'bizy_testimonials_layout3' );

/**
 * Testimonials
 */

function bizy_testimonials_layout3( $shortcode ) {

    $preview_dir = '//assets.aheto.co/testimonials/previews/';

    $shortcode->add_layout( 'bizy_layout3', [
        'title' => esc_html__( 'Bizy Yelloy', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout3.jpg',
    ] );

    $shortcode->add_dependecy( 'bizy_testimonials', 'template', [ 'bizy_layout3' ] );

    $shortcode->add_params( [
        'bizy_testimonials' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Modern Testimonials Items', 'bizy' ),
            'params'  => [
                'bizy_image'       => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Display Image', 'bizy' ),
                ],
                'bizy_name'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Name', 'bizy' ),
                    'default' => esc_html__( 'Author name', 'bizy' ),
                ],
                'bizy_company'     => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Position', 'bizy' ),
                    'default' => esc_html__( 'Author position', 'bizy' ),
                ],
                'bizy_testimonial' => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Testimonial', 'bizy' ),
                    'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'bizy' ),
                ],
            ],

        ],
        'bizy_background' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color for arrows', 'bizy' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'background: {{VALUE}}' ],
            'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
        ],
        'bizy_background_hover' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color for arrows on hover', 'bizy' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'background: {{VALUE}}' ],
            'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
        ],
    ] );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
        'custom_options' => true,
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'slides', 'spaces', ],
        'prefix'         => 'bizy_swiper_',
        'dependency'     => [ 'template', [ 'bizy_layout3' ] ]
    ] );

}
