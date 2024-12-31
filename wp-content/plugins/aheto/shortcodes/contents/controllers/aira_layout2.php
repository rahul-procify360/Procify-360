<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contents_register', 'aira_contents_layout2' );

/**
 * Contents Shortcode
 */

function aira_contents_layout2( $shortcode ) {

    $theme_dir = '//assets.aheto.co/contents/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Text Block', 'aira' ),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_title', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_title_tag', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_text', 'template', 'aira_layout2' );
    $shortcode->add_dependecy( 'aira_corner', 'template', 'aira_layout2');

    $shortcode->add_params( [
        'aira_corner'       => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable styled corner?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_title'            => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Title', 'aira' ),
            'description' => esc_html__( 'Add some text for Title', 'aira' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Add some text for Title', 'aira' ),
        ],
        'aira_title_tag'        => [
            'type'    => 'select',
            'heading' => esc_html__( 'Element tag for Title', 'aira' ),
            'options' => [
                'h1'  => 'h1',
                'h2'  => 'h2',
                'h3'  => 'h3',
                'h4'  => 'h4',
                'h5'  => 'h5',
                'h6'  => 'h6',
                'p'   => 'p',
                'div' => 'div',
            ],
            'default' => 'h2',
            'grid'    => 5,
        ],
        'aira_text'             => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Text', 'aira' ),
            'description' => esc_html__( 'Add some text', 'aira' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Add some text', 'aira' ),
        ],
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'aira_link_',
        'icons'      => true,
        'dependency' => [ 'template', 'aira_layout2' ],
    ] );

}
