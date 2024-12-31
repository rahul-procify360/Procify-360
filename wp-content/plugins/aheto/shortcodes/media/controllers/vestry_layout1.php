<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'vestry_media_layout1');


/**
 * Media Shortcode
 */

function vestry_media_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Media 22', 'vestry'),
		'image' => $preview_dir . 'vestry_layout1.jpg',
	]);

  $shortcode->add_dependecy('vestry_image', 'template', 'vestry_layout1');
  
  $shortcode->add_params([
		'vestry_image'     => [
			'type'    => 'attach_images',
			'heading' => esc_html__('Add image', 'vestry'),
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Images size', 'vestry'),
		'prefix'     => 'vestry_size_',
		'dependency' => ['template', ['vestry_layout1']]
	]);
}

