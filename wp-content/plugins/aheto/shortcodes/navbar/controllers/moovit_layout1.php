<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'moovit_navbar_layout1' );


/**
 * Navbar
 */

function moovit_navbar_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Navbar 10', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['max_width', 'remove_borders', 'columns', 'right_hide_mobile', 'right_links', 'left_links', 'left_hide_mobile', 'use_links_typo', 'links_typo', 'use_socials_typo', 'socials_typo'], [ 'moovit_layout1' ], $shortcode );

}