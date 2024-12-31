<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'soapy_media_layout2');


/**
 * Media Shortcode
 */

function soapy_media_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';
	$shortcode->add_layout('soapy_layout2', [
		'title' => esc_html__('Media 21', 'soapy'),
		'image' => $preview_dir . 'soapy_layout2.jpg',
	]);

	$shortcode->add_dependecy('soapy_gallery', 'template', 'soapy_layout2');
	$shortcode->add_dependecy('soapy_space', 'template', 'soapy_layout2');


	$shortcode->add_params([
		'soapy_gallery'     => [
			'type'    => 'group',
			'heading' => esc_html__('Gallery', 'soapy'),
			'params'  => [
				'soapy_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'soapy'),
				],
			],
		],
		'soapy_space' => [
			'type'    => 'switch',
			'heading' => esc_html__('Remove spaces?', 'soapy'),
			'grid'    => 3,
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'soapy_media_',
		'dependency' => ['template', ['soapy_layout2']]
	]);
}

