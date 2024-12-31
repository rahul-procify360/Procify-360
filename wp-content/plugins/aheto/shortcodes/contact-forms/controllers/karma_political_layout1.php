<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'karma_political_contact_forms_layout1' );

/**
 * Contact forms
 */

function karma_political_contact_forms_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Contact Form 11', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
	] );

}