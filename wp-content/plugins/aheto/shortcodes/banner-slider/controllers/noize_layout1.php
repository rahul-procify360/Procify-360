<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'noize_banner_slider_layout1' );

/**
 * Banner Slider
 */

function noize_banner_slider_layout1( $shortcode ) {
    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Banner Slider 19', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_creative_banners', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_subtitle_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_subtitle_text_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_subtitle_text_typo', 'noize_use_subtitle_typo', 'true' );

    aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'noize_layout1' ], $shortcode );

    $shortcode->add_params( [
        'noize_creative_banners' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Banners', 'noize' ),
            'params'  => [
                'noize_image'     => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Background Image', 'noize' ),
                ],
                'noize_add_left_image' => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Left Additional Image', 'noize' ),
                ],
                'noize_add_right_image' => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Right Additional Image', 'noize' ),
                ],
                'noize_title'     => [
                    'type'        => 'text',
                    'heading'     => esc_html__( 'Title', 'noize' ),
                ],
                'noize_subtitle'     => [
                    'type'        => 'text',
                    'heading'     => esc_html__( 'Subtitle', 'noize' ),
                ],
            ]
        ],
        'noize_use_subtitle_typo'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for subtitle?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_subtitle_text_typo'   => [
            'type'     => 'typography',
            'group'    => 'Noize Subtitle Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner__subtitle',
        ]
    ] );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'noize_swiper_',
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows_style', 'arrows', 'lazy', 'simulate_touch', 'arrows_num_typo', 'arrows_color', 'arrows_size'],
        'dependency'     => [ 'template', [ 'noize_layout1' ] ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'noize_',
        'dependency' => ['template', ['noize_layout1']]
    ] );
}

function noize_banner_slider_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_subtitle_typo'] ) && ! empty( $shortcode->atts['noize_subtitle_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-banner__subtitle'], $shortcode->parse_typography( $shortcode->atts['noize_subtitle_text_typo'] ) );
    }

    if ( !empty($shortcode->atts['noize_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['arrows_color']);
    }

    if ( !empty($shortcode->atts['noize_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['arrows_size'] );
    }

    return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'noize_banner_slider_layout1_dynamic_css', 10, 2 );