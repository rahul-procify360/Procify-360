<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'soapy_contact_info_layout3');

/**
 * Contact Info Type Shortcode
 */

function soapy_contact_info_layout3($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('soapy_layout3', [
		'title' => esc_html__('Contact Info 11', 'soapy'),
		'image' => $preview_dir . 'soapy_layout3.jpg',
	]);

	aheto_demos_add_dependency(['address', 'phone', 'email', 'use_typo_text', 'text_typo'], ['soapy_layout3'], $shortcode);

	$shortcode->add_dependecy('soapy_align', 'template', ['soapy_layout3']);

	$shortcode->add_params([
		'soapy_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'soapy'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
	]);
}
