<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'acacio_navbar_layout2' );


/**
 * Navbar
 */

function acacio_navbar_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'acacio_layout2', [
		'title' => esc_html__( 'Navbar 2', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout2.jpg',
	] );


    // Acacio Additional (fixed on scroll)
    $shortcode->add_dependecy( 'acacio_menus', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_transparent', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_fixed_menu', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_use_menu_typo', 'template', 'acacio_layout2' );


    $shortcode->add_dependecy( 'acacio_menu_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_menu_typo', 'acacio_use_menu_typo', 'true' );
    $shortcode->add_dependecy( 'acacio_transparent', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_transparent', 'acacio_menu_typo', 'false' );

    $shortcode->add_params( [
        'acacio_menus'         => [
            'type'    => 'select',
            'heading' => esc_html__( 'Additional Menu', 'acacio' ),
            'options' => \Aheto\Helper::choices_nav_menu(),
            'description' => esc_html__( 'Use menu with one level items', 'acacio' ),
        ],

        'acacio_transparent'     => [
            'type'    => 'select',
            'heading' => esc_html__('Type of menu', 'acacio'),
            'options' => [
                'transparent_dark' => esc_html__('Dark', 'acacio'),
                'transparent_white' => esc_html__('White', 'acacio'),
            ],
        ],
        'acacio_fixed_menu' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable fixed additional menu on scroll?', 'acacio' ),
            'grid'    => 6,
        ],
        'acacio_use_menu_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for menu?', 'acacio' ),
            'grid'    => 6,
        ],

        'acacio_menu_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Menu Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-navbar--inner ul li a',
        ],


    ] );
}

function acacio_navbar_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_menu_typo'] ) && ! empty( $shortcode->atts['acacio_menu_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-navbar--inner ul li a'], $shortcode->parse_typography( $shortcode->atts['acacio_menu_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_navbar_dynamic_css', 'acacio_navbar_layout2_dynamic_css', 10, 2 );