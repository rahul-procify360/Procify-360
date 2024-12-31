<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_pricing-tables_register', 'noize_pricing_tables_layout2' );



function noize_pricing_tables_layout2($shortcode) {
    $preview_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout( 'noize_layout2', [
        'title' => esc_html__( 'Pricing Tables 21', 'noize' ),
        'image' => $preview_dir . 'noize_layout2.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_use_typo', 'template', 'noize_layout2' );
    $shortcode->add_dependecy( 'noize_text_typo', 'template', 'noize_layout2' );
    $shortcode->add_dependecy( 'noize_text_typo', 'noize_use_typo', 'true' );

    $shortcode->add_dependecy( 'noize_load_items', 'template', 'noize_layout2' );

    $shortcode->add_params( [
        'noize_use_typo'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for price?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo'   => [
            'type'     => 'typography',
            'group'    => 'Noize Price Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing-tables--noize-lay2__price',
        ],
        'noize_load_items'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Noize Pricing Items', 'noize' ),
            'params'  => [
                'noize_load_image'      => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Image', 'noize' ),
                ],
                'noize_load_title'      => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Title', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
                'noize_load_price'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Price', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
            ],
        ],
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'noize_',
        'dependency' => [ 'template', [ 'noize_layout2' ] ]
    ] );
}

function noize_pricing_tables_layout2_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo'] ) && ! empty( $shortcode->atts['noize_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing-tables--noize-lay2__price'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'noize_pricing_tables_layout2_dynamic_css', 10, 2 );