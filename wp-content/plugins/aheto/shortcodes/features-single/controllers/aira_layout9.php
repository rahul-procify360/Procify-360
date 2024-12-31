<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_features-single_register', 'aira_features_single_layout9' );



/**
 * Features Single Shortcode
 */

function aira_features_single_layout9( $shortcode ) {

    $theme_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'aira_layout9', [
        'title' => esc_html__( 'Aira With Background', 'aira' ),
        'image' => $theme_dir . 'aira_layout9.jpg',
    ] );

    aheto_demos_add_dependency( ['s_heading','use_heading', 't_heading', 's_image','s_description','use_description', 't_description'], ['aira_layout9'], $shortcode );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_button' => true,
        'icons' => true,
        'prefix'     => 'aira_',
        'group' => 'Content',
        'dependency' => [ 'template', 'aira_layout9' ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'dependency' => ['template', ['aira_layout9']]
    ]);
}