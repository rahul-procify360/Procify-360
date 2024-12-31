<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_navigation_register', 'karma_political_navigation_layout1' );


/**
 * Navigation Shortcode
 */

function karma_political_navigation_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Navigation 13', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'karma_use_navmenu_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_navmenu_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_navmenu_typo', 'karma_use_navmenu_typo', 'true' );
	$shortcode->add_dependecy( 'karma_political_shop_account', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_menus_second', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_links_color', 'template', 'karma_political_layout1' );

	$shortcode->add_dependecy( 'karma_political_use_menu_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_menu_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_menu_typo', 'karma_political_use_menu_typo', 'true' );

	$shortcode->add_dependecy( 'karma_political_use_menu_mobile_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_menu_mobile_typo', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_menu_mobile_typo', 'karma_political_use_menu_mobile_typo', 'true' );

	aheto_demos_add_dependency( [ 'type_logo', 'text_logo', 'logo', 'mob_logo', 'networks', 'hovercolor', 'search', 'mini_cart', 'mobile_menu_width', 'use_mob_menu_title_typo', 'mob_menu_title_typo' ], [ 'karma_political_layout1' ], $shortcode );

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
            'selector' => '{{WRAPPER}} ul.main-header__menu > li > a, {{WRAPPER}} ul.sub-menu > li > a',
        ],
		'karma_political_use_menu_mobile_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for menu mobile text?', 'karma' ),
			'grid'    => 3,
		],
		'karma_political_menu_mobile_typo'     => [
			'type'     => 'typography',
			'group'    => 'Menu Text Mobile Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header--mobile ul.main-header__menu > li > a, {{WRAPPER}} .main-header--mobile ul.sub-menu > li > a',
		],

		'karma_use_navmenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for submenu items with images?', 'karma' ),
			'grid'    => 3,
			'label_block'  => true,
		],

		'karma_navmenu_typo'     => [
			'type'     => 'typography',
			'group'    => 'Karma Submenu with Images Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__main-line .main-header__pages-list li a',
		],
	] );

}

function karma_political_navigation_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset($shortcode->atts['karma_political_use_menu_typo']) && $shortcode->atts['karma_political_use_menu_typo'] && isset($shortcode->atts['karma_political_menu_typo']) && !empty($shortcode->atts['karma_political_menu_typo']) ) {
		\aheto_add_props($css['global']['%1$s .ul.main-header__menu > li > a, %1$s ul.sub-menu > li > a'], $shortcode->parse_typography($shortcode->atts['karma_political_menu_typo']));
	}

	if ( isset($shortcode->atts['karma_political_use_menu_mobile_typo']) && $shortcode->atts['karma_political_use_menu_mobile_typo'] && isset($shortcode->atts['karma_political_menu_mobile_typo']) && !empty($shortcode->atts['karma_political_menu_mobile_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header--mobile .ul.main-header__menu > li > a, %1$s .main-header--mobile ul.sub-menu > li > a'], $shortcode->parse_typography($shortcode->atts['karma_political_menu_mobile_typo']));
	}

	return $css;

}

add_filter( 'aheto_navigation_dynamic_css', 'karma_political_navigation_layout1_dynamic_css', 10, 2 );
