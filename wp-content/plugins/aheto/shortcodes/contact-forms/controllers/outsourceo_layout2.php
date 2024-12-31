<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'outsourceo_contact_forms_layout2' );

/**
 * Contact forms
 */

function outsourceo_contact_forms_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Contact Form 23', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );

}