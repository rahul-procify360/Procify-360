<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_media_register', 'karma_education_media_layout1' );

/**
 * Media Shortcode
 */

function karma_education_media_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

    $shortcode->add_layout( 'karma_education_layout1', [
        'title' => esc_html__( 'Media 14', 'karma' ),
        'image' => $preview_dir . 'karma_education_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'karma_education_video_slider', 'template', 'karma_education_layout1' );
    $shortcode->add_dependecy( 'karma_education_hide_pagination', 'template', 'karma_education_layout1' );

    $shortcode->add_dependecy( 'karma_education_use_bullets_color', 'template', 'karma_education_layout1' );
    $shortcode->add_dependecy( 'karma_education_bullet_color', 'karma_education_use_bullets_color', 'true' );

    $shortcode->add_dependecy( 'karma_education_use_bullets_color', 'template', 'karma_education_layout1' );
    $shortcode->add_dependecy( 'karma_education_bullet_color_active', 'karma_education_use_bullets_color', 'true' );

    $shortcode->add_dependecy( 'karma_education_image', 'template', 'karma_education_layout3' );

    $shortcode->add_params([

        'karma_education_video_slider' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Acacio Video Slider', 'karma' ),
            'params'  => [
                'karma_education_video_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Image', 'karma' ),
                ],
            ]
        ],
        'karma_education_hide_pagination'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Hide swiper pagination on desktop?', 'karma'),
            'grid'      => 4,
        ],
        'karma_education_use_bullets_color'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Add your colors for swiper bullets?', 'karma'),
            'grid'      => 4,
        ],
        'karma_education_bullet_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Swiper bullet color', 'karma' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}' ],
        ],
        'karma_education_bullet_color_active' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Swiper bullet active color', 'karma' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}}' ],
        ],

    ]);

    \Aheto\Params::add_video_button_params( $shortcode, [
        'add_label' => esc_html__( 'Add video?', 'karma' ),
        'prefix'    => 'karma_education_',
        'group'     => esc_html__( 'Video Content', 'karma' ),
    ], 'karma_education_video_slider' );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'group'      => esc_html__( 'Karma Education Swiper', 'karma' ),
        'custom_options' => true,
        'prefix'         => 'karma_education_swiper_',
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay','lazy', 'slides', 'pagination', 'arrows', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'karma_education_layout1' ] ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Karma images size for images ', 'karma' ),
        'prefix'     => 'karma_education_',
        'dependency' => ['template', ['karma_education_layout1'] ]
    ]);

}

function karma_education_media_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['karma_education_bullet_color'] ) ) {
        $color = Sanitize::color( $shortcode->atts['karma_education_bullet_color'] );
        $css['global']['%1$s .swiper-pagination-bullet']['background'] = $color;
    }

    if ( ! empty( $shortcode->atts['karma_education_bullet_color_active'] ) ) {
        $color = Sanitize::color( $shortcode->atts['karma_education_bullet_color_active'] );
        $css['global']['%1$s .swiper-pagination-bullet-active']['background'] = $color;
    }

    return $css;

}

add_filter( 'aheto_media_dynamic_css', 'karma_education_media_layout1_dynamic_css', 10, 2 );
