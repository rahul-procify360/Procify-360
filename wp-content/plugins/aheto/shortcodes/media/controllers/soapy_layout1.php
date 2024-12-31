<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'soapy_media_layout1');


/**
 * Media Shortcode
 */

function soapy_media_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';
	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Media 20', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	$shortcode->add_dependecy('soapy_image_video', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_video_link', 'template', 'soapy_layout1');



	$shortcode->add_params([
		'soapy_image_video' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Video image', 'soapy'),
		],
		'soapy_video_link'  => [
			'type'    => 'text',
			'heading' => esc_html__('Video Link', 'soapy'),
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'soapy_media_',
		'dependency' => ['template', ['soapy_layout1']]
	]);
}

