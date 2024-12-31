<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'karma_political_contacts_layout1' );

/**
 * Contacts
 */

function karma_political_contacts_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Contacts 8', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
	] );

	// Dependency.
	aheto_demos_add_dependency( [ 'phone', 'email', 'link_url', 'link_title', 'address', 'networks', 'use_content', 't_content' ], [ 'karma_political_layout1' ], $shortcode );

}