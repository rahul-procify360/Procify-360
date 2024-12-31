<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_navigation_register', 'kunst_navigation_layout1' );

/**
* Kunst Navigation
*/

function kunst_navigation_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'kunst_layout1', [
		'title' => esc_html__( 'Kunst Classic', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout1.jpg',
	]);


	aheto_demos_add_dependency( [  'networks' ], [ 'kunst_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_mob_menu_title', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_textlogo', 'template', 'kunst_layout1' );

	$shortcode->add_dependecy( 'kunst_use_mobmenu_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_mobmenu_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_mobmenu_typo', 'kunst_use_mobmenu_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_textlogo_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_textlogo_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_textlogo_typo', 'kunst_use_menu_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_menu_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_menu_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_menu_typo', 'kunst_use_menu_typo', 'true' );

    $shortcode->add_dependecy( 'kunst_use_submenu_link_typo', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_submenu_link_typo', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_submenu_link_typo', 'kunst_use_submenu_link_typo', 'true' );

	$shortcode->add_params([

		'kunst_mob_menu_title' => [
            'type'    => 'text',
            'heading' => esc_html__( 'Menu Mobile Title', 'kunst' ),
            'default' => esc_html__( 'Menu', 'kunst' ),
        ],
		'kunst_textlogo' => [
			'type'        => 'text',
            'heading'     => esc_html__( 'Text Logo', 'kunst' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Text Logo with text.', 'kunst' ),
		],

		'kunst_use_mobmenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Mobile Menu?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_mobmenu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Mobile Menu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-mob',
		],

		'kunst_use_textlogo_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for logo text?', 'kunst' ),
		],
		'kunst_textlogo_typo'        => [
			'type'     => 'typography',
			'group'    => 'Logo text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__text-logo-wrap',
		],

		'kunst_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for menu?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_menu_typo'        => [
			'type'     => 'typography',
			'group'    => 'Menu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu li a',
		],
        'kunst_use_submenu_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for submenu?', 'kunst' ),
            'grid'    => 3,
        ],
        'kunst_submenu_typo'        => [
            'type'     => 'typography',
            'group'    => 'Submenu Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .main-menu ul.sub-menu li a, {{WRAPPER}} .main-menu ul.sub-menu ul.sub-menu li a',
        ],
	]);
}

function kunst_navigation_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_mobmenu_typo']) && !empty($shortcode->atts['kunst_mobmenu_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__menu-mob'], $shortcode->parse_typography($shortcode->atts['kunst_mobmenu_typo']));
	}

	if ( !empty($shortcode->atts['kunst_use_textlogo_typo']) && !empty($shortcode->atts['kunst_textlogo_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-header__text-logo-wrap'], $shortcode->parse_typography($shortcode->atts['kunst_textlogo_typo']));
	}

	if ( !empty($shortcode->atts['kunst_use_menu_typo']) && !empty($shortcode->atts['kunst_menu_typo']) ) {
		\aheto_add_props($css['global']['%1$s .main-menu li a'], $shortcode->parse_typography($shortcode->atts['kunst_menu_typo']));
	}

	return $css;

}

add_filter('aheto_navigation_dynamic_css', 'kunst_navigation_layout1_dynamic_css', 10, 2);
