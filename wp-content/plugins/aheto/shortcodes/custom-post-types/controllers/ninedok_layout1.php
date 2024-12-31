<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'aheto_addon_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function aheto_addon_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'ninedok_layout1', [
		'title' => esc_html__( 'Custom Post Type 13', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );

    $shortcode->add_dependecy( 'ninedok_small_image', 'template', [ 'ninedok_layout1' ] );

	aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading', 'image_height', 'title_tag'], [ 'ninedok_layout1' ], $shortcode );

	$shortcode->add_params( [
        'ninedok_small_image' => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Small bottom image', 'ninedok' ),
        ],
	] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'grup' => 'Image original size background',
        'prefix'         => 'ninedok_',
        'dependency' => ['template',  ['ninedok_layout1']]
    ]);

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'ninedok_swiper_',
        'include'        => [ 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'ninedok_layout1' ] ]
    ] );

}




function ninedok_cpt_image_sizer_layout1( $image_sizer_layouts ) {

    $image_sizer_layouts[] = 'ninedok_layout1';

    return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'ninedok_cpt_image_sizer_layout1', 10, 2 );