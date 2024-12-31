<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_pricing-tables_register', 'acacio_pricing_tables_layout2' );


/**
 * Pricing Tables Shortcode
 */

function acacio_pricing_tables_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout( 'acacio_layout2', [
        'title' => esc_html__( 'Pricing Tables 2', 'acacio' ),
        'image' => $preview_dir . 'acacio_layout2.jpg',
    ] );

    aheto_demos_add_dependency( ['price', 'features', 'description'], [ 'acacio_layout2' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_heading', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_background', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_border', 'template', 'acacio_layout2' );
    
    $shortcode->add_dependecy( 'acacio_use_title_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'acacio_use_title_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_price_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_price_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_price_typo', 'acacio_use_price_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_features_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_features_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_features_typo', 'acacio_use_features_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_time_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_time_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_time_typo', 'acacio_use_time_typo', 'true' );

    $shortcode->add_params( [
        'acacio_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for heading?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Heading Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__title',
        ],
        'acacio_use_price_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for price?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_price_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Price Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
        ],
        'acacio_use_features_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for features?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_features_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Features Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__description li, {{WRAPPER}} .aheto-pricing__list-item',
        ],
        'acacio_use_time_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for cost time?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_time_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Cost Time Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__cost-time',
        ],

        'acacio_heading'    => [
            'type'        => 'text',
            'heading'     => esc_html__( 'Heading', 'acacio' ),
            'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'acacio' ),
            'default'     => esc_html__( 'Heading with [[ hightlight ]] text.', 'acacio' ),
            'admin_label' => true,
        ],
        'acacio_background' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color', 'acacio' ),
            'grid'      => 6,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-pricing--acacio-classic' => 'background: {{VALUE}}',
            ],
        ],
        'acacio_border'     => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Border color', 'acacio' ),
            'grid'      => 6,
            'default'   => '#223645',
            'selectors' => [
                '{{WRAPPER}} .aheto-pricing--acacio-classic' => 'border-top-color: {{VALUE}}',
            ],
        ],
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'acacio_',
        'dependency' => [ 'template', ['acacio_layout2' ] ]
    ] );
}

function acacio_pricing_tables_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_border'] ) ) {
        $css['global']['%1$s .aheto-pricing--acacio-classic']['border-top-color'] = \Aheto\Sanitize::color( $shortcode->atts['acacio_border'] );
    }
    if ( ! empty( $shortcode->atts['acacio_background'] ) ) {
        $css['global']['%1$s .aheto-pricing--acacio-classic']['background'] = \Aheto\Sanitize::color( $shortcode->atts['acacio_background'] );
    }
    if ( ! empty( $shortcode->atts['acacio_use_title_typo'] ) && ! empty( $shortcode->atts['acacio_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography( $shortcode->atts['acacio_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_price_typo'] ) && ! empty( $shortcode->atts['acacio_price_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography( $shortcode->atts['acacio_price_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_features_typo'] ) && ! empty( $shortcode->atts['acacio_features_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__description li'], $shortcode->parse_typography( $shortcode->atts['acacio_features_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_time_typo'] ) && ! empty( $shortcode->atts['acacio_time_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__cost-time'], $shortcode->parse_typography( $shortcode->atts['acacio_time_typo'] ) );
    }


    return $css;
}

add_filter( 'aheto_pricing-tables_dynamic_css', 'acacio_pricing_tables_layout2_dynamic_css', 10, 2 );