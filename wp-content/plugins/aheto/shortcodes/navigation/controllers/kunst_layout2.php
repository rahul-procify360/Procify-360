<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_navigation_register', 'kunst_navigation_layout2' );


/**
* Kunst Navigation
*/

function kunst_navigation_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'kunst_layout2' , [
		'title' => esc_html__( 'Kunst Menu Footer', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout2.jpg',
	]);

	aheto_demos_add_dependency( [ 'title', 'title_space', 'list_space', 'text_typo' ], [ 'kunst_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_links_color', 'template', 'kunst_layout2' );

	$shortcode->add_dependecy( 'kunst_use_menu_footer_typo', 'template', 'kunst_layout2' );
	$shortcode->add_dependecy( 'kunst_menu_footer_typo', 'template', 'kunst_layout2' );
	$shortcode->add_dependecy( 'kunst_menu_footer_typo', 'kunst_use_menu_footer_typo', 'true' );

	$shortcode->add_params([

		'kunst_links_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Links color', 'kunst' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .widget-nav-menu--menu .widget-nav-menu__menu li a' => 'color: {{VALUE}}' ],
        ],

        'kunst_use_menu_footer_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for menu footer?', 'kunst' ),
            'grid'    => 3,
        ],
        'kunst_menu_footer_typo'        => [
            'type'     => 'typography',
            'group'    => 'Menu Footer Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .widget-nav-menu__menu li a',
        ],

	]);
}

function kunst_navigation_layout2_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_menu_footer_typo']) && !empty($shortcode->atts['kunst_menu_footer_typo']) ) {
        \aheto_add_props($css['global']['%1$s .widget-nav-menu__menu li a'], $shortcode->parse_typography($shortcode->atts['kunst_menu_footer_typo']));
    }

	return $css;

}

add_filter('aheto_navigation_dynamic_css', 'kunst_navigation_layout2_dynamic_css', 10, 2);
