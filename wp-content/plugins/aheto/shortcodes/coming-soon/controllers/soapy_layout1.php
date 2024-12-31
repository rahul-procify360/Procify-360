<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_coming-soon_register', 'soapy_coming_soon_layout1' );


/**
 * Coming Soon Shortcode
 */

function soapy_coming_soon_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/coming-soon/previews/';

	$shortcode->add_layout( 'soapy_layout1', [
		'title' => esc_html__( 'Coming Soon 8', 'soapy' ),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	] );
	$shortcode->add_dependecy( 'soapy_remove_top_space', 'template', 'soapy_layout1' );

	aheto_demos_add_dependency( ['use_typo_numbers', 'typo_numbers'], [ 'soapy_layout1' ], $shortcode );
	$shortcode->add_params( [
		'soapy_remove_top_space' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Remove top space?', 'djo' ),
			'grid'    => 6,
		],
	] );

}