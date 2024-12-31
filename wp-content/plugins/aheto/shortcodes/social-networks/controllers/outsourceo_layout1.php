<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_social-networks_register', 'outsourceo_social_networks_layout1' );

/**
 * Outsourceo Socials
 */

function outsourceo_social_networks_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Social Networks 9', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['networks', 'size', 'socials_align', 'socials_align_mob'], [ 'outsourceo_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_dark_style', 'template', 'outsourceo_layout1' );
	$shortcode->add_params( [

		'outsourceo_dark_style'           => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark style for socials?', 'outsourceo' ),
			'grid'    => 3,
		],

	] );
}