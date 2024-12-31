<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'soapy_contact_forms_layout2');

/**
 * Contact forms Shortcode
 */

function soapy_contact_forms_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('soapy_layout2', [
		'title' => esc_html__('Contact Form 28', 'soapy'),
		'image' => $preview_dir . 'soapy_layout2.jpg',
	]);
}

function soapy_contact_forms_layout2_button($form_button) {
	$form_button['dependency'][1][] = 'soapy_layout2';
	return $form_button;
}

add_filter('aheto_button_contact-forms', 'soapy_contact_forms_layout2_button', 10, 2);

