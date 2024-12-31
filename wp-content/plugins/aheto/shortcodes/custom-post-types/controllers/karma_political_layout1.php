<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'karma_political_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function karma_political_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
        'title' => esc_html__( 'Custom Post Type 8', 'karma' ),
        'image' => $preview_dir . 'karma_political_layout1.jpg',
    ] );

	aheto_demos_add_dependency( [ 'skin', 'use_heading', 't_heading', 'title_tag' ], [ 'karma_political_layout1' ], $shortcode );

	\Aheto\Params::add_carousel_params( $shortcode, [
        'group'      => esc_html__( 'Karma Political Swiper', 'karma' ),
        'custom_options' => true,
        'prefix'         => 'karma_political_swiper_',
        'include'        => [ 'arrows', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows_style', 'arrows_num_typo', 'arrows_color', 'arrows_size' ],
        'dependency'     => [ 'template', [ 'karma_political_layout1' ] ]
    ] );

}

function karma_political_cpt_layout1_dynamic_css( $css, $shortcode ) {

    if ( !empty($shortcode->atts['karma_political_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['arrows_color']);
    }

    if ( !empty($shortcode->atts['karma_political_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['arrows_size'] );
    }

    return $css;

}

add_filter( 'aheto_cpt_dynamic_css', 'karma_political_cpt_layout1_dynamic_css', 10, 2 );