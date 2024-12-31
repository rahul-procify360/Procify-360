<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_features-single_register', 'aira_features_single_layout8' );



/**
 * Features Single Shortcode
 */

function aira_features_single_layout8( $shortcode ) {

    $theme_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout( 'aira_layout8', [
        'title' => esc_html__( 'Aira Large', 'aira' ),
        'image' => $theme_dir . 'aira_layout8.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_active', 'template', 'aira_layout8' );

    aheto_demos_add_dependency( ['s_heading','use_heading', 't_heading', 's_image','s_description','use_description', 't_description'], ['aira_layout8'], $shortcode );

    $shortcode->add_params( [
        'aira_active'     => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Mark as active?', 'aira' ),
            'grid'    => 12,
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'dependency' => ['template', ['aira_layout8']]
    ]);
}