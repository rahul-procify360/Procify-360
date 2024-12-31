<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_features-tabs_register', 'noize_features_tabs_layout1' );

/**
 * Features Tabs
 */

function noize_features_tabs_layout1($shortcode) {
    $preview_dir = '//assets.aheto.co/features-tabs/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Features Tabs 6', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_videos', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_video_name_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_video_name_text_typo', 'noize_use_video_name_typo', 'true' );

    $shortcode->add_dependecy( 'noize_use_duration_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_duration_text_typo', 'noize_use_duration_typo', 'true' );

    $shortcode->add_params([
        'noize_videos' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Videos', 'noize' ),
            'params'  => [
                'noize_video_name'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Video Name', 'noize'),
                    'grid'    => 6,
                ],
                'noize_video_url'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Video URL', 'noize'),
                    'grid'    => 6,
                ],
            ]
        ],
        'noize_use_video_name_typo'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for video name?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_video_name_text_typo'   => [
            'type'     => 'typography',
            'group'    => 'Noize Video Name Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto--noize-features-tabs__video-name',
        ],
         'noize_use_duration_typo'    => [
             'type'    => 'switch',
             'heading' => esc_html__( 'Use custom font for duration?', 'noize' ),
             'grid'    => 6,
         ],
         'noize_duration_text_typo'   => [
             'type'     => 'typography',
             'group'    => 'Noize Duration Typography',
             'settings' => [
                 'tag'        => false,
                 'text_align' => false,
             ],
             'selector' => '{{WRAPPER}} .aheto--noize-features-tabs__video-duration-thumbs',
         ]
    ]);
}

function noize_features_tabs_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_video_name_typo'] ) && ! empty( $shortcode->atts['noize_video_name_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto--noize-features-tabs__video-name'], $shortcode->parse_typography( $shortcode->atts['noize_video_name_text_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_duration_typo'] ) && ! empty( $shortcode->atts['noize_duration_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto--noize-features-tabs__video-duration-thumbs'], $shortcode->parse_typography( $shortcode->atts['noize_duration_text_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_features_tabs_dynamic_css', 'noize_features_tabs_layout1_dynamic_css', 10, 2 );