<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contents_register', 'aira_contents_layout3' );

/**
 * Contents Shortcode
 */

function aira_contents_layout3( $shortcode ) {

    $theme_dir = '//assets.aheto.co/contents/previews/';


    $shortcode->add_layout( 'aira_layout3', [
        'title' => esc_html__( 'Aira Creative slider', 'aira' ),
        'image' => $theme_dir . 'aira_layout3.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_creative_items', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_creative_version', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_dark_arrows', 'template', 'aira_layout3' );


    $shortcode->add_params( [
        'aira_creative_version' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Add shadow for text block?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_dark_arrows'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use dark theme for navigation arrows?', 'aira' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_creative_items'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Slides', 'aira' ),
            'params'  => [
                'aira_item_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Image', 'aira' ),
                ],
                'aira_item_title'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Title', 'aira' ),
                ],
                'aira_item_desc'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Description', 'aira' ),
                ],
                'aira_item_btn_direction' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Buttons Direction', 'aira' ),
                    'options' => [
                        ''            => esc_html__( 'Horizontal', 'aira' ),
                        'is-vertical' => esc_html__( 'Vertical', 'aira' ),
                    ],
                ],
            ]
        ],
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'aira_main_',
        'icons'  => true,
    ], 'aira_creative_items' );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_label' => esc_html__( 'Add additional button?', 'aira' ),
        'prefix'    => 'aira_add_',
        'icons'     => true,
    ], 'aira_creative_items' );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'aira_swiper_',
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'arrows_size'],
        'dependency'     => [ 'template', [ 'aira_layout3' ] ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'group'      => 'Image Size (Bottom background)',
        'dependency' => ['template', ['aira_layout3']]
    ]);

}

function aira_contents_layout3_dynamic_css( $css, $shortcode ) {

    if ( !empty($shortcode->atts['aira_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['aira_arrows_size'] );
    }
    return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'aira_contents_layout3_dynamic_css', 10, 2 );
