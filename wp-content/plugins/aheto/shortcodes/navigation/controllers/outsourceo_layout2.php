<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'outsourceo_navigation_layout2' );


/**
 * Navigation Shortcode
 */

function outsourceo_navigation_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Navigation 22', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );

	aheto_demos_add_dependency( ['title', 'title_space', 'list_space', 'text_typo', 'hovercolor'], [ 'outsourceo_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_links_color', 'template', 'outsourceo_layout2' );

	$shortcode->add_params( [
		'outsourceo_links_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links color', 'outsourceo' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .widget-nav-menu--outsourceo-menu .widget-nav-menu__menu li a' => 'color: {{VALUE}}' ],
		],
	] );
}