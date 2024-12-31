<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_features-single_register', 'aira_features_single_layout1' );



/**
 * Features Single Shortcode
 */

function aira_features_single_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    aheto_demos_add_dependency( ['s_heading','use_heading','t_heading','s_image'], ['aira_layout1'], $shortcode );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'dependency' => ['template', ['aira_layout1']]
    ]);

}
