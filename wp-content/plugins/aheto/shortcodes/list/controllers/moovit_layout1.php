<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'moovit_list_layout1' );

/**
 * List
 */

function moovit_list_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'List 13', 'moovit' ),
		'image' => $dir . 'acacio_layout3.jpg',
	] );

	aheto_demos_add_dependency( 'lists', [ 'moovit_layout1' ], $shortcode );

}