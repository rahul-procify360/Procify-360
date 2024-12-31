<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'soapy_features_single_layout1');


/**
 * Feature Single
 */

function soapy_features_single_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Features Single 48', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading', 'use_description', 't_description'], ['soapy_layout1'], $shortcode);

	$shortcode->add_dependecy('soapy_image_left', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_image_right', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_title', 'template', ['soapy_layout1']);
	$shortcode->add_dependecy('soapy_desc', 'template', ['soapy_layout1']);


	$shortcode->add_params([
		'soapy_image_left'  => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Before title image', 'soapy'),
		],
		'soapy_image_right' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('After title image', 'soapy'),
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
