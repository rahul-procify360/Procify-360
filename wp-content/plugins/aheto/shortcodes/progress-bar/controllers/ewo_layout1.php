<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'ewo_progress_bar_layout1' );
/**
 * Progress Bar Shortcode
 */

function ewo_progress_bar_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'ewo_layout1', [
		'title' => esc_html__( 'Progress Bar 3', 'ewo' ),
		'image' => $preview_dir . 'ewo_layout1.jpg',
  ] );
  
	aheto_demos_add_dependency( ['percentage', 'description'], [ 'ewo_layout1' ], $shortcode );
}
