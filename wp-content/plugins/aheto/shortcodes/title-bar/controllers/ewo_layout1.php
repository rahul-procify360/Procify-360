<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_title-bar_register', 'ewo_title_bar_layout1' );

/**
 * Title Bar
 */

function ewo_title_bar_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/title-bar/previews/';

	$shortcode->add_layout( 'ewo_layout1', [
		'title' => esc_html__( 'Title Bar 2', 'ewo' ),
		'image' => $dir . 'ewo_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['searchform', 'sf_button', 'sf_placeholder'], [ 'ewo_layout1' ], $shortcode );

}