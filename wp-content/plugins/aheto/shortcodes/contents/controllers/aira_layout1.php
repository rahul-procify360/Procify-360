<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contents_register', 'aira_contents_layout1' );

/**
 * Contents Shortcode
 */

function aira_contents_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/contents/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_video_image', 'aira_add_video_button', 'true' );
    $shortcode->add_dependecy( 'aira_image_size', 'aira_add_video_button', 'true' );
    $shortcode->add_dependecy( 'aira_back_image', 'template', 'aira_layout1' );

    \Aheto\Params::add_video_button_params( $shortcode, [
        'add_label'  => esc_html__( 'Add video?', 'aira' ),
        'prefix'     => 'aira_',
        'group'      => esc_html__( 'Video Content', 'aira' ),
        'dependency' => [ 'template', 'aira_layout1' ],
    ] );

    $shortcode->add_params( [
        'aira_video_image'      => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Preview image for video', 'aira' ),
            'group'   => esc_html__( 'Content', 'aira' ),
        ],
        'aira_back_image'      => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Background image', 'aira' ),
            'group'   => esc_html__( 'Content', 'aira' ),
        ],
        'aira_image_size' => [
            'type'    => 'select',
            'heading' => 'Image original size',
            'options' => Aheto\Helper::choices_image_size(),
            'grid'    => 4,
            'default' => 'full',
            'group'   => esc_html__( 'Content', 'aira' ),
        ],
    ] );


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'group'      => 'Image Size (Bottom background)',
        'dependency' => ['template', ['aira_layout1']]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_main_',
        'group'      => 'Image Size (Video preview background)',
        'dependency' => ['template', ['aira_layout1']]
    ]);
}
