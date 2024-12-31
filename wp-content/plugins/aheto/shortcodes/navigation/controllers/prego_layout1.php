<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'prego_navigation_layout1' );


/**
 * Navigation Shortcode
 */

function prego_navigation_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout( 'prego_layout1', [
        'title' => esc_html__( 'Prego Navigation', 'prego' ),
        'image' => $preview_dir . 'prego_layout1.jpg',
    ] );


    aheto_demos_add_dependency( ['transparent', 'type_logo', 'text_logo', 'logo', 'add_scroll_logo', 'scroll_logo', 'mob_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'max_width', 'mobile_menu_width'], [ 'prego_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'prego_use_logo_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_logo_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_logo_typo', 'prego_use_logo_typo', 'true' );
    $shortcode->add_dependecy( 'prego_use_menu_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_menu_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_menu_typo', 'prego_use_menu_typo', 'true' );
    $shortcode->add_dependecy( 'prego_use_megamenu_title_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_megamenu_title_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_megamenu_title_typo', 'prego_use_megamenu_title_typo', 'true' );

    $shortcode->add_params( [
        'prego_use_logo_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for logo?', 'prego' ),
            'grid'    => 6,
        ],

        'prego_logo_typo' => [
            'type'     => 'typography',
            'group'    => 'Prego Logo Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__logo span',
        ],
        'prego_use_menu_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for menu items?', 'prego' ),
            'grid'    => 6,
        ],

        'prego_menu_typo' => [
            'type'     => 'typography',
            'group'    => 'Prego Menu Items Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu>li>a, {{WRAPPER}} .main-header__menu-box>ul>li>a, {{WRAPPER}} .main-header__menu-box-title, {{WRAPPER}} .main-header__menu-box .btn-close, {{WRAPPER}} .main-header__menu-box .menu-item--mega-menu .mega-menu__col',
        ],
        'prego_use_megamenu_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Mega menu title?', 'prego' ),
            'grid'    => 6,
        ],

        'prego_megamenu_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Prego Mega Menu Title Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu__title, {{WRAPPER}} .main-header__menu-box>ul .menu-item--mega-menu .mega-menu__title',
        ],
    ] );


    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'prego_main_',
        'group'      => 'Desktop buttons',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'prego_layout1' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_label'  => esc_html__( 'Add additional button?', 'prego' ),
        'prefix'     => 'prego_add_',
        'group'      => 'Desktop buttons',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'prego_layout1' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'prego_main_mob_',
        'group'      => 'Mobile Buttons',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'prego_layout1' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_label'  => esc_html__( 'Add additional button?', 'prego' ),
        'prefix'     => 'prego_add_mob_',
        'group'      => 'Mobile Buttons',
        'icons'      => true,
        'add_button' => true,
        'dependency' => [ 'template', [ 'prego_layout1' ] ]
    ] );

}
