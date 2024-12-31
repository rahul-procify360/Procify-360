<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'sterling_contact_forms_layout1' );

/**
 * Contact forms
 */

function sterling_contact_forms_layout1($shortcode)
{
	$dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling subscribe form', 'sterling'),
		'image' => $dir . 'sterling_layout1.jpg',
	]);

	aheto_demos_add_dependency('bg_color_fields', ['sterling_layout1'], $shortcode);
}