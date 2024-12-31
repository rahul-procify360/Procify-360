<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'sterling_media_layout1');

function sterling_media_layout1($shortcode)
{
	$dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling media grid small', 'sterling'),
		'image' => $dir . 'sterling_layout1.jpg',
	]);

	$shortcode->add_dependecy('sterling_image', 'template', ['sterling_layout1']);

	$shortcode->add_params([
		'sterling_image'     => [
			'type'    => 'attach_images',
			'heading' => esc_html__('Add image', 'sterling'),
		]
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Images size', 'sterling'),
		'prefix'     => 'sterling_',
		'dependency' => ['template', ['sterling_layout1']]
	]);
}