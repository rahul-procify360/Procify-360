<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'bizy_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function bizy_custom_post_types_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/custom-post-types/previews/';

    $shortcode->add_layout( 'bizy_layout1', [
        'title' => esc_html__( 'Bizy Slider', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout1.jpg',
    ] );
    $shortcode->add_dependecy( 'bizy_img_gradient_color', 'template', 'bizy_layout1');
    $shortcode->add_dependecy( 'bizy_background', 'bizy_swiper_custom_options', 'true' );
    $shortcode->add_dependecy( 'bizy_background_hover', 'bizy_swiper_custom_options', 'true' );

    aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading', 'use_term', 't_term', 'image_height', 'title_tag' ], [ 'bizy_layout1' ], $shortcode );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
        'custom_options' => true,
        'prefix'         => 'bizy_swiper_',
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows','pagination', 'lazy', 'simulate_touch', 'slides', 'spaces', 'overflow' ],
        'dependency'     => [ 'template', [ 'bizy_layout1' ] ]
    ] );


    $shortcode->add_params( [
        'bizy_img_gradient_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Change background color gradient', 'bizy' ),
            'grid'      => 6,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .aheto-cpt-article__inner::after' => 'background-image: linear-gradient(to top,{{VALUE}},transparent)',
            ],  
        ],
        'bizy_background' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color for arrows', 'bizy' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-button-prev, {{WRAPPER}} .swiper-button-next' => 'background: {{VALUE}}' ],
            'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
        ],
        'bizy_background_hover' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color for arrows on hover', 'bizy' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-button-prev:hover, {{WRAPPER}} .swiper-button-next:hover' => 'background: {{VALUE}}' ],
            'group'          => esc_html__( 'Bizy Swiper', 'aheto' ),
        ],
    ] );

}

function bizy_cpt_image_sizer_layout1( $image_sizer_layouts ) {

    $image_sizer_layouts[] = 'bizy_layout1';

    return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'bizy_cpt_image_sizer_layout1', 10, 2 );


function bizy_cpt_layout1_dynamic_css( $css, $shortcode ) {

    if ( !empty($shortcode->atts['bizy_swiper_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['bizy_swiper_arrows_color']);
    }

    if ( !empty($shortcode->atts['bizy_swiper_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['bizy_swiper_arrows_size'] );
    }
    if ( ! empty( $shortcode->atts['bizy_img_gradient_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['bizy_img_gradient_color'] );
        $css['global']['%1$s .aheto-cpt-article__inner::after']['background-image'] = $color;
    }


    return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'bizy_cpt_layout1_dynamic_css', 10, 2 );