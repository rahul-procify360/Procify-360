<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_navigation_register', 'noize_navigation_layout1' );

function noize_navigation_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Navigation 20', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_logo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_menu_title', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_soc_icon_color', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_soc_icon_size', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_dropdown_icon_color', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_dropdown_icon_size', 'template', 'noize_layout1' );

    $shortcode->add_dependecy( 'noize_use_menu_item_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_menu_item_text_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_menu_item_text_typo', 'noize_use_menu_item_typo', 'true' );

    $shortcode->add_dependecy( 'noize_use_submenu_item_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_submenu_item_text_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_submenu_item_text_typo', 'noize_use_submenu_item_typo', 'true' );

    aheto_demos_add_dependency( ['max_width', 'type_logo', 'text_logo', 'logo', 'mob_logo', 'add_scroll_logo', 'scroll_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'networks', 'transparent', 'mobile_menu_width'], [ 'noize_layout1' ], $shortcode );

    $shortcode->add_params( [
        'noize_logo' => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Logo', 'noize' ),
            'grid'    => 0,
        ],
        'noize_menu_title' => [
            'type'    => 'text',
            'heading' => esc_html__( 'Menu Title', 'noize' ),
            'default' => esc_html__( 'Menu Title', 'noize' ),
            'grid'    => 6,
        ],
        'noize_use_menu_item_typo'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for menu item?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_menu_item_text_typo'   => [
            'type'     => 'typography',
            'group'    => 'Noize Menu Item Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu > .menu-item > a',
        ],
        'noize_use_submenu_item_typo'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for submenu item?', 'noize' ),
            'grid'    => 6,
        ],
        'noize_submenu_item_text_typo'   => [
            'type'     => 'typography',
            'group'    => 'Noize Submenu Item Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .sub-menu > .menu-item > a',
        ],
        'noize_soc_icon_color'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Social Icon Color', 'noize' ),
            'selectors' => [
                '{{WRAPPER}} .main-header__icon > i::before' => 'color: {{VALUE}}',
            ],
        ],
        'noize_soc_icon_size'   => [
            'type'     => 'text',
            'heading'   => esc_html__( 'Social Icon Size', 'noize' ),
            'selectors' => [
                '{{WRAPPER}} .main-header__icon > i::before' => 'font-size: {{VALUE}}px;',
            ],
        ],
        'noize_dropdown_icon_color'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Dropdown Icon Color', 'noize' ),
            'selectors' => [
                '{{WRAPPER}} span.dropdown-btn::before' => 'color: {{VALUE}}',
            ],
        ],
        'noize_dropdown_icon_size'   => [
            'type'     => 'text',
            'heading'   => esc_html__( 'Dropdown Icon Size', 'noize' ),
            'selectors' => [
                '{{WRAPPER}} span.dropdown-btn::before' => 'font-size: {{VALUE}};',
            ],
        ],
    ] );
}

function noize_navigation_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['noize_use_menu_item_typo'] ) && ! empty( $shortcode->atts['noize_menu_item_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-menu > .menu-item > a'], $shortcode->parse_typography( $shortcode->atts['noize_menu_item_text_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['noize_use_submenu_item_typo'] ) && ! empty( $shortcode->atts['noize_submenu_item_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .sub-menu > .menu-item > a'], $shortcode->parse_typography( $shortcode->atts['noize_submenu_item_text_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'noize_navigation_layout1_dynamic_css', 10, 2 );
