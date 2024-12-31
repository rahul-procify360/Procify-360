<?php

add_action( 'aheto_before_aheto_navigation_register', 'deva_navigation_layout1_shortcode' );

/**
 * Navigation shortcode
 */
function deva_navigation_layout1_shortcode($shortcode){

    $dir =  '//assets.aheto.co/navigation/previews/';

    $shortcode->add_layout('deva_layout1', [
        'title' => esc_html__('Deva Simple', 'deva'),
        'image' => $dir . 'deva_layout1.jpg',
    ]);

	aheto_demos_add_dependency( ['max_width', 'type_logo', 'mob_logo', 'transparent', 'add_scroll_logo', 'add_mob_scroll_logo', 'use_mega_menu_title_typo', 'mega_menu_title_typo', 'use_menu_link_typo', 'menu_link_typo', 'use_logo_typo', 'logo_typo', 'logo', 'text_logo', 'scroll_logo', 'scroll_mob_logo', 'mobile_menu_width'], [ 'deva_layout1' ], $shortcode);

	$shortcode->add_dependecy( 'deva_center_menu', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_use_navmenu_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_navmenu_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_navmenu_typo', 'deva_use_navmenu_typo', 'true' );
	$shortcode->add_dependecy( 'deva_use_submenu_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_submenu_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_submenu_typo', 'deva_use_submenu_typo', 'true' );
	$shortcode->add_dependecy( 'deva_use_mobmenu_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_mobmenu_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_mobmenu_typo', 'deva_use_mobmenu_typo', 'true' );
	$shortcode->add_dependecy( 'deva_use_mobback_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_mobback_typo', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_mobback_typo', 'deva_use_mobback_typo', 'true' );
	$shortcode->add_dependecy( 'deva_max_width_mega', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_sub_style', 'template', 'deva_layout1' );
	$shortcode->add_dependecy( 'deva_count_images_col', 'template', 'deva_layout1' );

	$shortcode->add_params([
		'deva_count_images_col'         => [
			'type'    => 'slider',
			'heading' => esc_html__( 'Columns in megamenu with images', 'aheto' ),
			'description' => esc_html__( 'Columns count in megamenu with images (only number)', 'aheto' ),
			'admin_label' => true,
			'grid' => 6,
			'range' => [
				'px' => [
					'min' => 1,
					'max' => 10,
					'step' => 1,
				],
			],
			'default' => [
				'unit' => 'px',
				'size' => 6,
			],
			'selectors' => [
				'{{WRAPPER}} .main-header__menu-box .main-menu .main-header__pages-list li, {{WRAPPER}} .main-header__menu-box>ul .main-header__pages-list li' => 'width: calc(100% / {{SIZE}})' ]
		],
		'deva_center_menu' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable center menu?', 'deva' ),
			'grid'    => 3,
		],
		'deva_sub_style' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use another style for sub menu?', 'deva' ),
			'grid'    => 3,
		],

		'deva_use_navmenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for submenu items with images?', 'deva' ),
			'grid'    => 3,
			'label_block'  => true,
		],

		'deva_navmenu_typo'     => [
			'type'     => 'typography',
			'group'    => 'Deva Submenu with Images Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-header__main-line .main-header__pages-list li a',
		],

		'deva_use_submenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for submenu items?', 'deva' ),
			'grid'    => 3,
			'label_block'  => true,
		],

		'deva_submenu_typo'     => [
			'type'     => 'typography',
			'group'    => 'Deva Submenu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu--inline .sub-menu:not(.main-header__pages-list) a',
		],
		'deva_use_mobmenu_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for mobile menu?', 'deva' ),
			'grid'    => 3,
			'label_block'  => true,
		],

		'deva_mobmenu_typo'     => [
			'type'     => 'typography',
			'group'    => 'Deva Mobile Menu Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-open.main-header__menu-box li a, {{WRAPPER}} .menu-open.main-header__menu-box .mega-menu__title',
		],
		'deva_use_mobback_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for mobile back button?', 'deva' ),
			'grid'    => 3,
			'label_block'  => true,
		],

		'deva_mobback_typo'     => [
			'type'     => 'typography',
			'group'    => 'Deva Mobile Back Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-open.main-header__menu-box .deva-back',
		],
		'deva_max_width_mega'          => [
			'type'      => 'slider',
			'heading'   => esc_html__('Max width for megamenu', 'deva'),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .main-header--desktop .main-header__menu-box .main-menu .menu-item--mega-menu .mega-menu' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		],
	]);
}


function deva_navigation_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['deva_use_navmenu_typo'] ) && ! empty( $shortcode->atts['deva_navmenu_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .main-header__pages-list li a'], $shortcode->parse_typography( $shortcode->atts['deva_navmenu_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['deva_use_mobmenu_typo'] ) && ! empty( $shortcode->atts['deva_mobmenu_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .menu-open.main-header__menu-box li a, %1$s .menu-open.main-header__menu-box .mega-menu__title, %1$s .menu-open.main-header__menu-box .mobile-menu-title'], $shortcode->parse_typography( $shortcode->atts['deva_mobmenu_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['deva_use_mobback_typo'] ) && ! empty( $shortcode->atts['deva_mobback_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .menu-open.main-header__menu-box .deva-back'], $shortcode->parse_typography( $shortcode->atts['deva_mobback_typo'] ) );
	}

	return $css;

}

add_filter( 'aheto_navigation_dynamic_css', 'deva_navigation_layout1_dynamic_css', 10, 2 );


function deva_nav_desc_button_layouts($desc_button_layouts) {

    $desc_button_layouts[] = 'deva_layout1';

    return $desc_button_layouts;
}

add_filter('aheto_nav_desc_button_layouts', 'deva_nav_desc_button_layouts', 10, 2);
