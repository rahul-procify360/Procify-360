<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_blockquote_register', 'noize_blockquote_layout1' );

/**
 * Blockquote
 */

function noize_blockquote_layout1($shortcode) {
    $preview_dir = '//assets.aheto.co/blockquote/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Blockquote 4', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ]);

    $shortcode->add_dependecy( 'noize_quote', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_author', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_position', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_align_tablet', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_align_mobile', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_typo_quote', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_quote', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_quote', 'noize_use_typo_quote', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_author', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_author', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_author', 'noize_use_typo_author', 'true' );

    $shortcode->add_dependecy( 'noize_use_typo_position', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_position', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_text_typo_position', 'noize_use_typo_position', 'true' );

    $shortcode->add_params([
        'noize_use_typo_quote'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for quote?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_quote'   => [
            'type'     => 'typography',
            'group'    => 'Noize Quote Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-blockquote__quote',
        ],
        'noize_quote'      => [
            'type'    => 'textarea',
            'heading' => esc_html__('Quote', 'noize'),
        ],
        'noize_use_typo_author'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for author?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_author'   => [
            'type'     => 'typography',
            'group'    => 'Noize Author Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-blockquote__author',
        ],
        'noize_author'     => [
            'type'    => 'text',
            'heading' => esc_html__('Author', 'noize'),
            'grid'    => 6,
        ],
        'noize_position'     => [
            'type'    => 'text',
            'heading' => esc_html__('Position', 'noize'),
            'grid'    => 6,
        ],
        'noize_use_typo_position'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for position?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_text_typo_position'   => [
            'type'     => 'typography',
            'group'    => 'Noize Position Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-blockquote__position',
        ],
        'noize_align_tablet' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for tablet', 'noize' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
        ],
        'noize_align_mobile' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for mobile', 'noize' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
        ]
    ]);
}

function noize_blockquote_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_typo_quote'] ) && ! empty( $shortcode->atts['noize_text_typo_quote'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-blockquote__quote'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_quote'] ) );
    }

    if ( ! empty( $shortcode->atts['noize_use_typo_author'] ) && ! empty( $shortcode->atts['noize_text_typo_author'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-blockquote__author'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_author'] ) );
    }

    if ( ! empty( $shortcode->atts['noize_use_typo_position'] ) && ! empty( $shortcode->atts['noize_text_typo_position'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-blockquote__position'], $shortcode->parse_typography( $shortcode->atts['noize_text_typo_position'] ) );
    }

    return $css;
}

add_filter( 'aheto_blockquotes_dynamic_css', 'noize_blockquotes_layout1_dynamic_css', 10, 2 );