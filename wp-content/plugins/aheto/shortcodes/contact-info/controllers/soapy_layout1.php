<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'soapy_contact_info_layout1');

/**
 * Contact Info Type Shortcode
 */

function soapy_contact_info_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Contact Info 9', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['title', 'use_typo', 'title_typo', 'type_logo', 'logo','use_typo_logo', 'logo_typo', 'address', 'phone', 'email', 'use_typo_text', 'text_typo'], ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_align', 'template', ['soapy_layout1']);
	$shortcode->add_params([
		'soapy_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'soapy'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
	]);
}
