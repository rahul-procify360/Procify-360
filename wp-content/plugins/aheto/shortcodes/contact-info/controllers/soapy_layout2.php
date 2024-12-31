<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'soapy_contact_info_layout2');

/**
 * Contact Info Type Shortcode
 */

function soapy_contact_info_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

	$shortcode->add_layout('soapy_layout2', [
		'title' => esc_html__('Contact Info 10', 'soapy'),
		'image' => $preview_dir . 'soapy_layout2.jpg',
	]);

	aheto_demos_add_dependency(['title', 'use_typo', 'title_typo', 'use_typo_text', 'text_typo'], ['soapy_layout2'], $shortcode);

	$shortcode->add_dependecy('soapy_align', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_image', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_text', 'template', 'soapy_layout2');
	$shortcode->add_params([
		'soapy_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'soapy'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'soapy_image'      => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image', 'soapy'),
		],
		'soapy_text'       => [
			'type'    => 'textarea',
			'heading' => esc_html__('Content', 'soapy'),
		],
	]);
}
