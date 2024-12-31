<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_navbar_register', 'aira_navbar_layout1' );



/**
 * Navbar Shortcode
 */
function aira_navbar_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/navbar/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_bot_border', 'template', 'aira_layout1' );

    aheto_demos_add_dependency( ['max_width','remove_borders','columns','left_links','left_hide_mobile','use_links_typo','use_socials_typo', 'right_links', 'right_hide_mobile', 'links_typo', 'socials_typo'], [ 'aira_layout1' ], $shortcode );

    $shortcode->add_params( [
        'aira_bot_border'     => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Turn on bottom divider?', 'aira' ),
            'grid'    => 12,
        ],
    ] );
}