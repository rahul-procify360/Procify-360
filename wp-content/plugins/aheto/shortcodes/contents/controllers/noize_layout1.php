<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'noize_contents_layout1' );

/**
 * Contents Shortcode
 */
function noize_contents_layout1( $shortcode ) {
    $preview_dir = '//assets.aheto.co/contents/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Content 24', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_contents', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_typo_contents_category', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_contents_category', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_contents_category', 'noize_use_typo_contents_category', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_title_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_title_name', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_title_name', 'noize_use_typo_title_name', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_desc_category', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_desc_category', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_desc_category', 'noize_use_typo_desc_category', 'true' );

    $shortcode->add_params( [
        'noize_contents' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Noize contents items', 'noize' ),
            'params'  => [
                'noize_contents_heading_tag'  => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Element tag for heading', 'noize' ),
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
                    'default' => 'h4',
                    'grid'    => 5,
                ],
                'noize_contents_category'     => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Contents category', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
                'noize_contents_heading'        => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Contents heading', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
                'noize_contents_descr'        => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Contents description', 'noize' ),
                    'default' => esc_html__( 'Put your text...', 'noize' ),
                ],
            ],
        ],
        'noize_use_typo_contents_category'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for filter category?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_contents_category'   => [
            'type'     => 'typography',
            'group'    => 'Noize Filter Category Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__content',
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
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__title-content',
        ],
        'noize_use_typo_desc_category'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_desc_category'   => [
            'type'     => 'typography',
            'group'    => 'Noize Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-contents__desc-content',
        ],
    ] );
}

function noize_contents_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo_contents_category'] ) && ! empty( $shortcode->atts['noize_text_typo_contents_category'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__content'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_contents_category'] ) );
    }

    if ( ! empty( $shortcode->atts['noize_use_typo_title_name'] ) && ! empty( $shortcode->atts['noize_text_typo_title_name'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__title-content'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_title_name'] ) );
    }

    if ( ! empty( $shortcode->atts['noize_use_typo_desc_category'] ) && ! empty( $shortcode->atts['noize_text_typo_desc_category'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contents__desc-content'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_desc_category'] ) );
    }

    return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'noize_contents_layout1_dynamic_css', 10, 2 );