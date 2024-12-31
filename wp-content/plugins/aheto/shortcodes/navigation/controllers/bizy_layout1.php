<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'bizy_navigation_layout1' );


/**
 * Navigation Shortcode
 */

function bizy_navigation_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout( 'bizy_layout1', [
        'title' => esc_html__( 'Bizy Grid menu', 'bizy' ),
        'image' => $preview_dir . 'bizy_layout1.jpg',
    ] );


    aheto_demos_add_dependency( ['type_logo', 'mob_logo', 'transparent', 'add_scroll_logo','add_mob_scroll_logo', 'use_mob_menu_title_typo', 'mob_menu_title_typo', 'text_logo', 'logo', 'scroll_logo', 'scroll_mob_logo', 'mobile_menu_width' ], [ 'bizy_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'bizy_submenu_bg_color', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_submenu_color', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_use_logo_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_logo_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_logo_typo', 'bizy_use_logo_typo', 'true' );
    $shortcode->add_dependecy( 'bizy_use_menu_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_menu_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_menu_typo', 'bizy_use_menu_typo', 'true' );
    $shortcode->add_dependecy( 'bizy_use_megamenu_title_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_megamenu_title_typo', 'template', 'bizy_layout1' );
    $shortcode->add_dependecy( 'bizy_megamenu_title_typo', 'bizy_use_megamenu_title_typo', 'true' );

    $shortcode->add_params( [
	    'bizy_submenu_bg_color' => [
		    'type'      => 'colorpicker',
		    'heading'   => esc_html__( 'Change submenu background color', 'bizy' ),
		    'grid'      => 6,
		    'selectors' => [ '{{WRAPPER}} .main-header__menu-box .sub-menu,{{WRAPPER}} .main-header__menu-box .mega-menu__list' => 'background: {{VALUE}}!important' ],
	    ],
	    'bizy_submenu_color' => [
		    'type'      => 'colorpicker',
		    'heading'   => esc_html__( 'Change submenu text color', 'bizy' ),
		    'grid'      => 6,
		    'selectors' => [ '{{WRAPPER}} .main-header__menu-box .main-menu ul li:not(.current-menu-item):not(.current-menu-parent) a, {{WRAPPER}} .main-header__menu-box .main-menu .menu-item--mega-menu div.mega-menu__title' => 'color: {{VALUE}}' ],
	    ],
        'bizy_use_logo_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for logo?', 'bizy' ),
            'grid'    => 6,
        ],
        'bizy_logo_typo' => [
            'type'     => 'typography',
            'group'    => 'Bizy Logo Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__logo span',
        ],
        'bizy_use_menu_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for menu items?', 'bizy' ),
            'grid'    => 6,
        ],
        'bizy_menu_typo' => [
            'type'     => 'typography',
            'group'    => 'Bizy Menu Items Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu>li>a, {{WRAPPER}} .main-header__menu-box>ul>li>a, {{WRAPPER}} .main-header__menu-box-title, {{WRAPPER}} .main-header__menu-box .btn-close, {{WRAPPER}} .main-header__menu-box .menu-item--mega-menu .mega-menu__col',
        ],
        'bizy_use_megamenu_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Mega menu title?', 'bizy' ),
            'grid'    => 6,
        ],
        'bizy_megamenu_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Bizy Mega Menu Title Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu__title, {{WRAPPER}} .main-header__menu-box>ul .menu-item--mega-menu .mega-menu__title',
        ],
    ] );


    \Aheto\Params::add_button_params( $shortcode, [
        'prefix'     => 'bizy_main_',
        'group'      => 'Bizy button',
        'icons'      => true,
        'add_button' => true,
        'include'    => [
            'style',
            'type',
            'underline',
        ],
        'dependency' => [ 'template', [ 'bizy_layout1' ] ]
    ] );
}



function bizy_navigation_layout1_shortcode_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['bizy_use_logo_typo'] ) && ! empty( $shortcode->atts['bizy_logo_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography( $shortcode->atts['bizy_logo_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['bizy_use_menu_typo'] ) && ! empty( $shortcode->atts['bizy_menu_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu>li>a, %1$s .main-header__menu-box>ul>li>a, %1$s .main-header__menu-box-title, %1$s .main-header__menu-box .btn-close, %1$s .main-header__menu-box .menu-item--mega-menu .mega-menu__col'], $shortcode->parse_typography( $shortcode->atts['bizy_menu_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['bizy_use_megamenu_title_typo'] ) && ! empty( $shortcode->atts['bizy_megamenu_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu__title, %1$s .main-header__menu-box>ul .menu-item--mega-menu .mega-menu__title'], $shortcode->parse_typography( $shortcode->atts['bizy_megamenu_title_typo'] ) );
    }


    return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'bizy_navigation_layout1_shortcode_dynamic_css', 10, 2 );
