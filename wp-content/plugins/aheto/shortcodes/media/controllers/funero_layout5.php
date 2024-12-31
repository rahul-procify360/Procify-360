<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'funero_media_layout5');

/**
 * Media member
 */

function funero_media_layout5($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('funero_layout5', [
		'title' => esc_html__('Media 10', 'funero'),
		'image' => $preview_dir . 'funero_layout5.jpg',
	]);

	$shortcode->add_dependecy('funero_images', 'template', ['funero_layout5']);


	$shortcode->add_params([
		'funero_images' => [
			'type'    => 'attach_images',
			'heading' => esc_html__('Add image', 'funero'),
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => 'Funero Image',
		'prefix'     => 'funero_media_',
		'dependency' => ['template', ['funero_layout5']]
	]);
}
