<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_navigation_register', 'karma_political_navigation_layout2' );

/**
 * Navigation Shortcode
 */

function karma_political_navigation_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'karma_political_layout2', [
		'title' => esc_html__( 'Navigation 14', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout2.jpg',
	] );

    $shortcode->add_dependecy( 'karma_political_columns', 'template', 'karma_political_layout2' );

    $shortcode->add_dependecy( 'karma_political_use_navmenu_typo', 'template', 'karma_political_layout2' );
    $shortcode->add_dependecy( 'karma_political_navmenu_typo', 'template', 'karma_political_layout2' );
    $shortcode->add_dependecy( 'karma_political_navmenu_typo', 'karma_political_use_navmenu_typo', 'true' );

	aheto_demos_add_dependency( [ 'list_space', 'hovercolor', 'mobile_menu_width' ], [ 'karma_political_layout2' ], $shortcode );

	$shortcode->add_params( [

		'karma_political_use_navmenu_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for nav menu text?', 'karma' ),
            'grid'    => 3,
        ],

        'karma_political_navmenu_typo'     => [
            'type'     => 'typography',
            'group'    => 'Karma Political Menu Text Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} ul.aheto-nav-columns__menu > li > a',
        ],
        'karma_political_columns'      => [
            'type'    => 'select',
            'heading' => esc_html__( 'Number of columns', 'karma' ),
            'options' => [
                'one' => esc_html__( 'One', 'karma' ),
                'two'   => esc_html__( 'Two', 'karma' ),
            ],
        ],

	] );

}

function karma_political_navigation_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['karma_political_use_navmenu_typo'] ) && ! empty( $shortcode->atts['karma_political_navmenu_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s ul.aheto-nav-columns__menu > li > a'], $shortcode->parse_typography( $shortcode->atts['karma_political_navmenu_typo'] ) );
    }

    return $css;

}

add_filter( 'aheto_navigation_dynamic_css', 'karma_political_navigation_layout2_dynamic_css', 10, 2 );