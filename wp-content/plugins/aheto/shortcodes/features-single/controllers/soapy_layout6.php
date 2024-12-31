<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'soapy_features_single_layout6');

/**
 * Feature Single
 */

function soapy_features_single_layout6($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('soapy_layout6', [
		'title' => esc_html__('Features Single 53', 'soapy'),
		'image' => $preview_dir . 'soapy_layout6.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading', 'use_description', 't_description'], ['soapy_layout6'], $shortcode);

	$shortcode->add_dependecy('soapy_title', 'template', ['soapy_layout6']);
	$shortcode->add_dependecy('soapy_desc', 'template', ['soapy_layout6']);
	$shortcode->add_dependecy('soapy_image_bg', 'template', ['soapy_layout6']);

	$shortcode->add_params([
		'soapy_image_bg'    => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image', 'soapy'),
		],
		'soapy_title'       => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'soapy'),
		],
		'soapy_desc'        => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'soapy'),
		],
	]);
}
