<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'outsourceo_navigation_layout1' );


/**
 * Navigation Shortcode
 */

function outsourceo_navigation_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Navigation 21', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );


	aheto_demos_add_dependency( ['transparent', 'type_logo', 'text_logo', 'logo', 'add_scroll_logo', 'scroll_logo', 'mob_logo', 'add_mob_scroll_logo', 'scroll_mob_logo', 'max_width', 'mobile_menu_width'], [ 'outsourceo_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_use_logo_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_logo_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_logo_typo', 'outsourceo_use_logo_typo', 'true' );
	$shortcode->add_dependecy( 'outsourceo_use_menu_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_menu_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_menu_typo', 'outsourceo_use_menu_typo', 'true' );
	$shortcode->add_dependecy( 'outsourceo_use_megamenu_title_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_megamenu_title_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_megamenu_title_typo', 'outsourceo_use_megamenu_title_typo', 'true' );

	$shortcode->add_params( [
		'outsourceo_use_logo_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for logo?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_logo_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Logo Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .main-header__logo span',
		],
		'outsourceo_use_menu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for menu items?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_menu_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Menu Items Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu>li>a, {{WRAPPER}} .main-header__menu-box>ul>li>a, {{WRAPPER}} .main-header__menu-box-title, {{WRAPPER}} .main-header__menu-box .btn-close, {{WRAPPER}} .main-header__menu-box .menu-item--mega-menu .mega-menu__col',
		],
		'outsourceo_use_megamenu_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Mega menu title?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_megamenu_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Mega Menu Title Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu__title, {{WRAPPER}} .main-header__menu-box>ul .menu-item--mega-menu .mega-menu__title',
		],
	] );


	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'outsourceo_main_',
		'group'      => 'Desktop buttons',
		'icons'      => true,
		'add_button' => true,
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label'  => esc_html__( 'Add additional button?', 'outsourceo' ),
		'prefix'     => 'outsourceo_add_',
		'group'      => 'Desktop buttons',
		'icons'      => true,
		'add_button' => true,
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'outsourceo_main_mob_',
		'group'      => 'Mobile Buttons',
		'icons'      => true,
		'add_button' => true,
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label'  => esc_html__( 'Add additional button?', 'outsourceo' ),
		'prefix'     => 'outsourceo_add_mob_',
		'group'      => 'Mobile Buttons',
		'icons'      => true,
		'add_button' => true,
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

}



function outsourceo_navigation_layout1_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_logo_typo'] ) && ! empty( $shortcode->atts['outsourceo_logo_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .main-header__logo span'], $shortcode->parse_typography( $shortcode->atts['outsourceo_logo_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['outsourceo_use_menu_typo'] ) && ! empty( $shortcode->atts['outsourceo_menu_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu>li>a, %1$s .main-header__menu-box>ul>li>a, %1$s .main-header__menu-box-title, %1$s .main-header__menu-box .btn-close, %1$s .main-header__menu-box .menu-item--mega-menu .mega-menu__col'], $shortcode->parse_typography( $shortcode->atts['outsourceo_menu_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['outsourceo_use_megamenu_title_typo'] ) && ! empty( $shortcode->atts['outsourceo_megamenu_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu__title, %1$s .main-header__menu-box>ul .menu-item--mega-menu .mega-menu__title'], $shortcode->parse_typography( $shortcode->atts['outsourceo_megamenu_title_typo'] ) );
	}


	return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'outsourceo_navigation_layout1_shortcode_dynamic_css', 10, 2 );