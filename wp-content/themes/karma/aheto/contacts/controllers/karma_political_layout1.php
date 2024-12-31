<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'karma_political_contacts_layout1' );

/**
 * Contacts
 */

function karma_political_contacts_layout1( $shortcode ) {

	$preview_dir = get_template_directory_uri() . '/aheto/contacts/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Karma Political Simple', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
	] );

	// Dependency.
	karma_add_dependency( 'phone', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'email', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'link_url', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'link_title', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'address', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'networks', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( ['use_content', 't_content'], [ 'karma_political_layout1' ], $shortcode );

//     karma_add_dependency( 'email', 'template', 'karma_political_layout1' );
//     karma_add_dependency( 'phone', 'template', 'karma_political_layout1' );
//     karma_add_dependency( 'link_url', 'template', 'karma_political_layout1' );
//     karma_add_dependency( 'link_title', 'template', 'karma_political_layout1' );
//     karma_add_dependency( 'address', 'template', 'karma_political_layout1' );
//     karma_add_dependency( 'networks', 'template', 'karma_political_layout1' );
//     karma_add_dependency( ['use_content', 't_content'], 'template', 'karma_political_layout1' );
}