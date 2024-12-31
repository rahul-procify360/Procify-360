<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_portfolio-nav_register', 'acacio_portfolio_nav_layout1' );


/**
 * Portfolio Nav Shortcode
 */

function acacio_portfolio_nav_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/portfolio-nav/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Portfolio Nav 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

}