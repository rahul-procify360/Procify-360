<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_social-networks_register', 'pointe_social_networks_layout1' );

/**
 * Social Networks
 */

function pointe_social_networks_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';

	$shortcode->add_layout( 'pointe_layout1', [
		'title' => esc_html__( 'Pointe Socials', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	] );
	aheto_demos_add_dependency(['networks', 'size', 'style', 'hovercolor_circle', 'hovercolor_default', 'color', 'socials_align', 'socials_align_mob', 'scheme'], ['pointe_layout1'], $shortcode);
}