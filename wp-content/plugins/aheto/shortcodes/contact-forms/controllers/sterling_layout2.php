<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'sterling_contact_forms_layout2' );

/**
 * Contact forms
 */

function sterling_contact_forms_layout2($shortcode)
{
	$dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('sterling_layout2', [
		'title' => esc_html__('Sterling register form', 'sterling'),
		'image' => $dir . 'sterling_layout2.jpg',
	]);

	aheto_demos_add_dependency('bg_color_fields', ['sterling_layout2'], $shortcode);

	$shortcode->add_dependecy('sterling_form_width', 'template', 'sterling_layout2');
	$shortcode->add_params([
		'sterling_form_width'   => [
			'type'     => 'text',
			'heading'   => esc_html__('Max-width for Form', 'sterling'),
			'selectors' => ['{{WRAPPER}} .widget_aheto__form' => 'max-width: {{VALUE}}']
		],
	]);
}