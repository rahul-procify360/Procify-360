<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'acacio_navigation_layout1' );


/**
 * Navbar
 */

function acacio_navigation_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Navigation 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

    aheto_demos_add_dependency( ['transparent', 'type_logo', 'text_logo', 'logo', 'add_scroll_logo', 'scroll_logo', 'mobile_menu_width', 'mob_logo', 'add_mob_scroll_logo', 'use_mob_menu_title_typo', 'mob_menu_title_typo', 'scroll_mob_logo'], [ 'acacio_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_use_links_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_links_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_links_typo', 'acacio_use_links_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_mega_menu_title', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_t_mega_menu_title', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_t_mega_menu_title', 'acacio_use_mega_menu_title', 'true' );

	$shortcode->add_dependecy( 'acacio_use_sub_menu_link', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_t_sub_menu_link', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_t_sub_menu_link', 'acacio_use_sub_menu_link', 'true' );

    $shortcode->add_params([
        'acacio_use_links_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for links?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_links_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Links Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .main-menu li a',
        ],
	    'acacio_use_mega_menu_title'  => [
		    'type'    => 'switch',
		    'heading' => esc_html__('Use custom font for Mega menu title?', 'ninedok'),
		    'grid'    => 6,
	    ],
	    'acacio_t_mega_menu_title'       => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Mega Menu Title Typography',
		    'settings' => [
			    'tag' => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .mega-menu__title',
	    ],
	    'acacio_use_sub_menu_link'  => [
		    'type'    => 'switch',
		    'heading' => esc_html__('Use custom font for submenu link?', 'ninedok'),
		    'grid'    => 6,
	    ],
	    'acacio_t_sub_menu_link'       => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Submenu Link Typography',
		    'settings' => [
			    'tag' => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} ul li ul a',
	    ],

    ]);
}

function acacio_navigation_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_links_typo'] ) && ! empty( $shortcode->atts['acacio_links_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-menu li a'], $shortcode->parse_typography( $shortcode->atts['acacio_links_typo'] ) );
    }
	if ( ! empty( $shortcode->atts['acacio_use_mega_menu_title'] ) && ! empty( $shortcode->atts['acacio_t_mega_menu_title'] ) ) {
		\aheto_add_props( $css['global']['%1$s .mega-menu__title'], $shortcode->parse_typography( $shortcode->atts['acacio_t_mega_menu_title'] ) );
	}
	if ( ! empty( $shortcode->atts['acacio_use_sub_menu_link'] ) && ! empty( $shortcode->atts['acacio_t_sub_menu_link'] ) ) {
		\aheto_add_props( $css['global']['%1$s ul li ul a'], $shortcode->parse_typography( $shortcode->atts['acacio_t_sub_menu_link'] ) );
	}


    return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'acacio_navigation_layout1_dynamic_css', 10, 2 );
