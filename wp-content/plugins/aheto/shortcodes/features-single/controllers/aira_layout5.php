<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_features-single_register', 'aira_features_single_layout5' );



/**
 * Features Single Shortcode
 */

function aira_features_single_layout5( $shortcode ) {

    $theme_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'aira_layout5', [
        'title' => esc_html__( 'Aira Simple', 'aira' ),
        'image' => $theme_dir . 'aira_layout5.jpg',
    ] );

    aheto_demos_add_dependency( ['s_heading','use_heading', 't_heading', 's_image','s_description'], ['aira_layout5'], $shortcode );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_w_',
        'dependency' => ['template', ['aira_layout5']]
    ]);

}