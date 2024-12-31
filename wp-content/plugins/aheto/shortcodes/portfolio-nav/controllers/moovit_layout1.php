<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_portfolio-nav_register', 'moovit_portfolio_nav_layout1' );


/**
 * Portfolio Nav Shortcode
 */

function moovit_portfolio_nav_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/portfolio-nav/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Portfolio Nav 3', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

}