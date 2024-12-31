<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_testimonials_register', 'aira_testimonials_layout4' );


/**
 * Testimonials Shortcode
 */

function aira_testimonials_layout4( $shortcode ) {

    $theme_dir = '//assets.aheto.co/testimonials/previews/';

    $shortcode->add_layout( 'aira_layout4', [
        'title' => esc_html__( 'Aira Single', 'aira' ),
        'image' => $theme_dir . 'aira_layout4.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_single_name', 'template', 'aira_layout4' );
    $shortcode->add_dependecy( 'aira_single_image', 'template', 'aira_layout4' );
    $shortcode->add_dependecy( 'aira_position', 'template', 'aira_layout4' );
    $shortcode->add_dependecy( 'aira_testimonial_single', 'template', 'aira_layout4' );

    $shortcode->add_params( [
        'aira_testimonial_single' => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Testimonial', 'aira' ),
            'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'aira' ),
        ],
        'aira_single_image'       => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Display Image', 'aira' ),
        ],
        'aira_single_name'        => [
            'type'    => 'text',
            'heading' => esc_html__( 'Name', 'aira' ),
            'default' => esc_html__( 'Author name', 'aira' ),
        ],

        'aira_position'     => [
            'type'    => 'text',
            'heading' => esc_html__( 'Position', 'aira' ),
            'default' => esc_html__( 'Author position', 'aira' ),
        ],
    ] );
}
