<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_features-single_register', 'aira_features_single_layout2' );



/**
 * Features Single Shortcode
 */

function aira_features_single_layout2( $shortcode ) {

    $theme_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Classic', 'aira' ),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ] );

    aheto_demos_add_dependency( ['s_heading','s_image','s_description'], ['aira_layout2'], $shortcode );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_w_',
        'dependency' => ['template', ['aira_layout2']]
    ]);

}
