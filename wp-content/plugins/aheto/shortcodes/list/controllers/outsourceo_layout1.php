<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'outsourceo_list_layout1' );

/**
 * List Shortcode
 */

function outsourceo_list_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'List 19', 'outsourceo' ),
		'image' => $dir . 'acacio_layout3.jpg',
	] );

	aheto_demos_add_dependency( 'lists', [ 'outsourceo_layout1' ], $shortcode );
}