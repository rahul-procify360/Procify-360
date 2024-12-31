<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'soapy_features_single_layout2');


/**
 * Feature Single
 */

function soapy_features_single_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('soapy_layout2', [
		'title' => esc_html__('Features Single 49', 'soapy'),
		'image' => $preview_dir . 'soapy_layout2.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading', 'use_description', 't_description'], ['soapy_layout2'], $shortcode);

	$shortcode->add_dependecy('soapy_title', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_desc', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_image_bg', 'template', ['soapy_layout2']);
	$shortcode->add_dependecy('soapy_link_title', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_link_url', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_color_desc', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_color1', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_color2', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_align', 'template', 'soapy_layout2');

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
		'soapy_link_title'  => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'soapy'),
		],
		'soapy_link_url'    => [
			'type'    => 'link',
			'heading' => esc_html__('Link URL', 'soapy'),
		],
		'soapy_color_desc'         => [
			'type'    => 'heading',
			'heading' => esc_html__('Add border color. Two colors set gradient border-color . Single color sets  one color  of the entire border', 'soapy'),
			'grid'    => 3,
		],
		'soapy_color1'             => [
			'type'    => 'colorpicker',
			'heading' => esc_html__('Select color 1', 'soapy'),
			'grid'    => 12,
			'desc'    => esc_html__('Color for background', 'soapy'),
		],
		'soapy_color2'             => [
			'type'    => 'colorpicker',
			'heading' => esc_html__('Select color 2', 'soapy'),
			'grid'    => 12,
			'desc'    => esc_html__('Color for background (if it option chosen background will be gradient)', 'soapy'),
		],
		'soapy_align'              => [
			'type'    => 'select',
			'heading' => esc_html__('Align Button', 'soapy'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix' => 'soapy_',
		'dependency' => ['template', ['soapy_layout2']]
	]);
}

