<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_pricing-tables_register', 'aira_pricing_tables_layout2' );


/**
 * Pricing Tables Shortcode
 */
function aira_pricing_tables_layout2( $shortcode ) {

    $theme_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Isotope', 'aira' ),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ] );

    $shortcode->add_dependecy('aira_pricings', 'template', 'aira_layout2');
    $shortcode->add_dependecy('aira_head_back_image', 'template', 'aira_layout2');

    $shortcode->add_dependecy('aira_use_title_price_typo', 'template', 'aira_layout2' );
    $shortcode->add_dependecy('aira_title_price_typo', 'aira_use_title_price_typo', 'true' );

    $shortcode->add_params( [
        'aira_pricings' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Aira Pricing Items', 'aira' ),
            'params'  => [
                'aira_pricings_heading'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Category', 'aira' ),
                    'default' => esc_html__( 'Put your text...', 'aira' ),
                ],
                'aira_pricings_title'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Category heading', 'aira' ),
                    'default' => esc_html__( 'Put your text...', 'aira' ),
                ],
                'aira_pricings_label'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Category label', 'aira' ),
                    'default' => esc_html__( '', 'aira' ),
                ],
                'aira_pricings_price'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Category price', 'aira' ),
                    'default' => esc_html__( 'Put your text...', 'aira' ),
                ],
                'aira_pricings_descr'        => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Category description', 'aira' ),
                    'default' => esc_html__( 'Put your text...', 'aira' ),
                ],
            ],
        ],
        'aira_use_title_price_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Title and price?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_title_price_typo' => [
            'type'     => 'typography',
            'group'    => 'Title and price Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__box-title, .aheto-pricing__box-price',
        ],
        'aira_head_back_image'      => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Background image for header', 'aira' ),
            'group'   => esc_html__( 'Content', 'aira' ),
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'group'      => 'Image Size (Header background)',
        'dependency' => ['template', ['aira_layout2']]
    ]);
}

function aira_pricing_tables_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_title_price_typo'] ) && ! empty( $shortcode->atts['aira_title_price_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__box-title, .aheto-pricing__box-price'], $shortcode->parse_typography( $shortcode->atts['aira_title_price_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'aira_pricing_tables_layout2_dynamic_css', 10, 2 );