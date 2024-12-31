<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contacts_register', 'outsourceo_contacts_layout1' );

/**
 * Contacts Shortcode
 */

function outsourceo_contacts_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contacts/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Contacts 15', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_text', 'template', 'outsourceo_layout1' );


	$shortcode->add_params( [
		'outsourceo_text' => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Text', 'outsourceo' ),
			'description' => esc_html__( 'Add some text for contacts', 'outsourceo' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for contacts', 'outsourceo' ),
		]

	] );
}