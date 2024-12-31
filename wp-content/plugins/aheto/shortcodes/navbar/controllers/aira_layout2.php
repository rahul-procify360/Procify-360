<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_navbar_register', 'aira_navbar_layout2' );



/**
 * Navbar Shortcode
 */
function aira_navbar_layout2( $shortcode ) {

    $theme_dir = '//assets.aheto.co/navbar/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Footer Minimal', 'aira' ),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ] );

    aheto_demos_add_dependency( ['max_width','remove_borders','columns','left_links','left_hide_mobile','use_links_typo','use_socials_typo', 'right_links', 'right_hide_mobile', 'links_typo', 'socials_typo'], [ 'aira_layout2' ], $shortcode );
}