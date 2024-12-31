<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_pricing-tables_register', 'aira_pricing_tables_layout1' );


/**
 * Pricing Tables Shortcode
 */
function aira_pricing_tables_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_features', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_active', 'template', 'aira_layout1' );

    $shortcode->add_dependecy( 'aira_use_heading_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_heading_typo', 'aira_use_heading_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_price_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_price_typo', 'aira_use_price_typo', 'true' );

    aheto_demos_add_dependency(['heading','price'], ['aira_layout1'], $shortcode);

    $shortcode->add_params( [
        'aira_use_heading_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Heading?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_heading_typo' => [
            'type'     => 'typography',
            'group'    => 'Heading Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__title',
        ],
        'aira_active'     => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Mark as active?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_use_price_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Price?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_price_typo' => [
            'type'     => 'typography',
            'group'    => 'Price Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
        ],
        'aira_features'          => [
            'type'    => 'group',
            'heading' => esc_html__('Features', 'aira' ),
            'params'  => [
                'aira_feature' => [
                    'type'    => 'text',
                    'heading' => esc_html__('Feature', 'aira' ),
                ],
                'aira_mark' => [
                    'type'    => 'select',
                    'heading' => esc_html__('Decoration', 'aira' ),
                    'default' => 'default',
                    'options' => [
                        'default'   => esc_html__('Default', 'aira' ),
                        'line-through'   => esc_html__('Line-through', 'aira' ),
                        'opacity'   => esc_html__('Opacity', 'aira' ),
                    ],
                ],
            ],
        ],
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_button' => true,
        'prefix'     => 'aira_',
        'dependency' => [ 'template', 'aira_layout1' ]
    ] );
}

function aira_pricing_tables_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_heading_typo'] ) && ! empty( $shortcode->atts['aira_heading_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography( $shortcode->atts['aira_heading_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['aira_use_price_typo'] ) && ! empty( $shortcode->atts['aira_price_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography( $shortcode->atts['aira_price_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_pricing_tables_dynamic_css', 'aira_pricing_tables_layout1_dynamic_css', 10, 2 );
