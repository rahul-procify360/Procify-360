<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'acacio_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function acacio_custom_post_types_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/custom-post-types/previews/';

    $shortcode->add_layout( 'acacio_layout1', [
        'title' => esc_html__( 'Custom Post Type 1', 'acacio' ),
        'image' => $preview_dir . 'acacio_layout1.jpg',
    ] );

    aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading', 'image_height', 'use_term', 't_term'], [ 'acacio_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_hide_pagination', 'template', 'acacio_layout1' );

    
    $shortcode->add_params([
        'acacio_hide_pagination'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Hide swiper pagination on desktop?', 'acacio'),
            'grid'      => 4,
        ],
    ]);

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'acacio_swiper_',
        'include'        => [ 'arrows', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'acacio_layout1' ] ]
    ] );

}

function acacio_cpt_image_sizer_layout1( $image_sizer_layouts ) {

    $image_sizer_layouts[] = 'acacio_layout1';

    return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'acacio_cpt_image_sizer_layout1', 10, 2 );
