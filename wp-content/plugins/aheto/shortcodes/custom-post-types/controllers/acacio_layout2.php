<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'acacio_custom_post_types_layout2' );

/**
 * Custom Post Type
 */

function acacio_custom_post_types_layout2( $shortcode ) {

    $preview_dir = '//assets.aheto.co/custom-post-types/previews/';

    $shortcode->add_layout( 'acacio_layout2', [
        'title' => esc_html__( 'Custom Post Type 2', 'acacio' ),
        'image' => $preview_dir . 'acacio_layout2.jpg',
    ] );

    aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading', 'image_height', 'use_term', 't_term'], [ 'acacio_layout2' ], $shortcode );
}
