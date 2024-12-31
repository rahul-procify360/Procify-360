<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_navigation_register', 'karma_political_navigation_layout1' );


/**
 * Navigation Shortcode
 */

function karma_political_navigation_layout1( $shortcode ) {

	$preview_dir = get_template_directory_uri() . '/aheto/navigation/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Karma Menu', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'karma_political_shop_account', 'template', 'karma_political_layout1' );

	$shortcode->add_dependecy( 'karma_political_menus_second', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_links_color', 'template', 'karma_political_layout1' );

	$shortcode->add_dependecy( 'karma_political_use_menu_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_menu_typo', 'karma_political_use_menu_typo', 'true' );

	karma_add_dependency( 'title', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'title_space', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'list_space', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( ['type_logo', 'text_logo', 'logo'], [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'mob_logo', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'networks', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'hovercolor', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'search', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'mini_cart', [ 'karma_political_layout1' ], $shortcode );

	$shortcode->add_params( [
		'karma_political_shop_account'        => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Account', 'karma' ),
        ],
		'karma_political_menus_second'         => [
            'type'    => 'select',
            'heading' => esc_html__( 'Second Menu', 'karma' ),
            'options' => Helper::choices_nav_menu(),
        ],
		'karma_political_links_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links color', 'karma' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .widget-nav-menu--menu .widget-nav-menu__menu li a' => 'color: {{VALUE}}' ],
		],
		'karma_political_use_menu_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for menu text?', 'karma' ),
            'grid'    => 3,
        ],
        'karma_political_menu_typo'     => [
            'type'     => 'typography',
            'group'    => 'Menu Text Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} ul.main-header__menu > li > a, ul.sub-menu > li > a',
        ],
	] );
	
}

function karma_political_navigation_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['karma_political_use_menu_typo'] ) && ! empty( $shortcode->atts['karma_political_menu_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s ul.main-header__menu > li > a, ul.sub-menu > li > a'], $shortcode->parse_typography( $shortcode->atts['karma_political_menu_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'karma_political_navigation_layout1_dynamic_css', 10, 2 );