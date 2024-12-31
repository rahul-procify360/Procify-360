<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_pricing-tables_register', 'noize_pricing_tables_layout1' );



function noize_pricing_tables_layout1($shortcode) {
    $preview_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Pricing Tables 20', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    // Noize Filter Pricing
    $shortcode->add_dependecy( 'noize_pricings', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_typo_pricing_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_pricing_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_pricing_name', 'noize_use_typo_pricing_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_title_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_title_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_title_name', 'noize_use_typo_title_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_desc_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_desc_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_desc_name', 'noize_use_typo_desc_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_pricing_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_pricing_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_pricing_name', 'noize_use_typo_pricing_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_pricing_category', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_pricing_category', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_pricing_category', 'noize_use_typo_pricing_category', 'true' );

    $shortcode->add_params( [
        'noize_pricings' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Noize Pricing Items', 'noize' ),
            'params'  => [
                'noize_pricings_heading'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Category', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
                'noize_pricings_title'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Category heading', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
                'noize_pricings_price'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Category price', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
                'noize_pricings_descr'        => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Category description', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
            ],
        ],
        'noize_use_typo_title_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for heading?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_title_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Heading Typography',
            'settings' => [
                'tag'        => false
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing-tables--noize-lay1__box-title',
        ],
        'noize_use_typo_desc_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_desc_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Description Typography',
            'settings' => [
                'tag'        => false
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing-tables--noize-lay1__box-descr',
        ],
        'noize_use_typo_pricing_name'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for price?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_pricing_name'   => [
            'type'     => 'typography',
            'group'    => 'Noize Price Typography',
            'settings' => [
                'tag'        => false
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing-tables--noize-lay1__box-price',
        ],
        'noize_use_typo_pricing_category'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for category?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_pricing_category'   => [
            'type'     => 'typography',
            'group'    => 'Noize Category Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing-tables--noize-lay1-item--category',
        ],
    ] );


    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'noize_',
        'dependency' => [ 'template', [ 'noize_layout2' ] ]
    ] );

}


function noize_pricing_tables_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo_title_name'] ) && ! empty( $shortcode->atts['noize_text_typo_title_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing-tables--noize-lay1__box-title'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_title_name'] ) );
    }

    if ( ! empty( $shortcode->atts['noize_use_typo_desc_name'] ) && ! empty( $shortcode->atts['noize_text_typo_desc_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing-tables--noize-lay1__box-descr'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_desc_name'] ) );
    }

    if ( ! empty( $shortcode->atts['noize_use_typo_pricing_name'] ) && ! empty( $shortcode->atts['noize_text_typo_pricing_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing-tables--noize-lay1__box-price'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_pricing_name'] ) );
    }

    if ( ! empty( $shortcode->atts['noize_use_typo_pricing_category'] ) && ! empty( $shortcode->atts['noize_text_typo_pricing_category'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing-tables--noize-lay1-item--category'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_pricing_category'] ) );
    }

    return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'noize_pricing_tables_layout1_dynamic_css', 10, 2 );