<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_custom-post-types_register', 'aira_custom_post_types_layout1' );



/**
 * Custom post type style for blog items
 */
function aira_custom_post_types_layout1($shortcode) {

    $theme_dir = '//assets.aheto.co/custom-post-types/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Slider', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    aheto_demos_add_dependency( [
        'skin',
        't_heading',
        'use_heading',
        'image_height',
        'title_tag'
    ], [ 'aira_layout1' ], $shortcode );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'aira_swiper_',
        'include'        => [ 'arrows', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows_size' ],
        'dependency'     => [ 'template', [ 'aira_layout1' ] ]
    ] );
}


function aira_cpt_image_sizer_layout1( $image_sizer_layouts ) {

    $image_sizer_layouts[] = 'aira_layout1';
    return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'aira_cpt_image_sizer_layout1', 10, 2 );

function aira_cpt_layout1_dynamic_css( $css, $shortcode ) {

    if ( !empty($shortcode->atts['aira_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['aira_arrows_size'] );
    }
    return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'aira_cpt_layout1_dynamic_css', 10, 2 );