<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'ninedok_navbar_layout1' );


/**
 * Navbar
 */

function ninedok_navbar_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'ninedok_layout1', [
		'title' => esc_html__( 'Navbar 12', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );


	aheto_demos_add_dependency( ['remove_borders', 'columns', 'right_hide_mobile', 'right_links', 'left_links', 'left_hide_mobile', 'use_links_typo', 'links_typo', 'use_socials_typo', 'socials_typo'], [ 'ninedok_layout1' ], $shortcode );

}