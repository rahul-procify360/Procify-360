<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'hryzantema_navigation_layout1');

/**
 * Contact forms Shortcode
 */

function hryzantema_navigation_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Navigation 10', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_demos_add_dependency(['logo','mob_logo','transparent', 'mobile_menu_width'], ['hryzantema_layout1'], $shortcode);


	$shortcode->add_dependecy( 'hryzantema_use_links_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_links_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_links_typo', 'hryzantema_use_links_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_use_logo_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_logo_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_logo_typo', 'hryzantema_use_logo_typo', 'true' );
	$shortcode->add_params([
		'hryzantema_use_links_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for navigation links?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_links_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Navigation Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .main-menu li > a',
		],
		'hryzantema_use_logo_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for navigation logo?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_logo_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Logo Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-logo main-header__logo span',
		],
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'hryzantema_nav_main_',
		'group'   => 'Hryzantema Desktop buttons',
		'icons'      => true,
		'dependency' => ['template', ['hryzantema_layout1']]
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'hryzantema_nav_main_mob_',
		'group'   => 'Hryzantema Mobile Buttons',
		'icons'      => true,
		'dependency' => ['template', ['hryzantema_layout1']]
	]);
}
function hryzantema_navigation_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_links_typo'] ) && $shortcode->atts['hryzantema_use_links_typo']  && isset( $shortcode->atts['hryzantema_links_typo'] ) && ! empty( $shortcode->atts['hryzantema_links_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .main-menu li a'], $shortcode->parse_typography( $shortcode->atts['hryzantema_links_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_logo_typo'] ) && $shortcode->atts['hryzantema_use_logo_typo'] && ! empty( $shortcode->atts['hryzantema_logo_typo'] ) && isset( $shortcode->atts['hryzantema_logo_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-logo main-header__logo span'], $shortcode->parse_typography( $shortcode->atts['hryzantema_logo_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'hryzantema_navigation_layout1_dynamic_css', 10, 2 );
