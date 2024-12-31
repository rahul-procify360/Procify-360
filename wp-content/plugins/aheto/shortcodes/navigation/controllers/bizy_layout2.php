<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'bizy_navigation_layout2' );


/**
 * Navigation Shortcode
 */

function bizy_navigation_layout2( $shortcode ) {

    $preview_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout( 'bizy_layout2', [
        'title' => esc_html__( 'Bizy Simple', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout2.jpg',
    ] );


    aheto_demos_add_dependency( ['max_width', 'type_logo', 'mob_logo', 'transparent', 'add_scroll_logo', 'add_mob_scroll_logo', 'use_mob_menu_title_typo', 'mob_menu_title_typo', 'use_mega_menu_title_typo', 'mega_menu_title_typo', 'use_menu_link_typo', 'menu_link_typo', 'use_logo_typo', 'logo_typo', 'logo', 'text_logo', 'scroll_logo', 'scroll_mob_logo', 'mobile_menu_width'], [ 'bizy_layout2' ], $shortcode );


    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'bizy_',
        'group'      => 'Bizy Desktop button',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'bizy_layout2' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'bizy_scroll_',
        'group'      => 'Bizy Scroll button',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'bizy_layout2' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'bizy_mob_',
        'group'      => 'Bizy Mobile button',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'bizy_layout2' ] ]
    ] );
}
