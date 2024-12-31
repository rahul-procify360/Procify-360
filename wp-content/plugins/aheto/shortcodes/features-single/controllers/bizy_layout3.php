<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'bizy_features_single_layout3' );

/**
 * Features Single
 */

function bizy_features_single_layout3( $shortcode ) {

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'bizy_layout3', [
        'title' => esc_html__( 'Bizy Simple', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout3.jpg',
    ] );

    $shortcode->add_dependecy( 'bizy_text', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_image', 'template', 'bizy_layout3' );
    $shortcode->add_dependecy( 'bizy_link_url', 'template', 'bizy_layout3' );

    $shortcode->add_params( [
        'bizy_text'   => [
            'type'    => 'text',
            'heading' => esc_html__('Title', 'bizy'),
            'grid'    => 9,
            'default' => esc_html__('Please add your title text.', 'bizy')
        ],
        'bizy_image' => [
            'type' => 'attach_image',
            'heading' => esc_html__('Image', 'bizy'),
        ],
        'bizy_link_url'=> [
            'type'    => 'link',
            'heading' => esc_html__('Link URL', 'bizy'),
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Bizy Images Size', 'bizy' ),
        'prefix'     => 'bizy_',
        'dependency' => ['template', ['bizy_layout3']]
    ]);

}