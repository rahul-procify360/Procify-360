<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'famulus_media_layout2');


/**
 * Media Shortcode
 */

function famulus_media_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('famulus_layout2', [
		'title' => esc_html__('Media 5', 'famulus'),
		'image' => $preview_dir . 'famulus_layout2.jpg',
	]);

	$shortcode->add_dependecy('famulus_image_video', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_video_link', 'template', 'famulus_layout2');
	$shortcode->add_dependecy('famulus_high_video', 'template', 'famulus_layout2');


	$shortcode->add_params([

		'famulus_image_video' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Video image', 'famulus'),
		],
		'famulus_video_link'  => [
			'type'    => 'text',
			'heading' => esc_html__('Video Link', 'famulus'),
		],
		'famulus_high_video'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Higher Video?', 'famulus'),
			'grid'    => 3,
		],


	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'famulus_',
		'dependency' => ['template', 'famulus_layout2']
	]);

}

