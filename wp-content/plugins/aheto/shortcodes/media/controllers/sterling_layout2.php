<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'sterling_media_layout2');

function sterling_media_layout2($shortcode)
{
	$dir = '//assets.aheto.co/media/previews/';


	$shortcode->add_layout('sterling_layout2', [
		'title' => esc_html__('Sterling media grid', 'sterling'),
		'image' => $dir . 'sterling_layout2.jpg',
	]);

	$shortcode->add_dependecy('sterling_all_item', 'template', ['sterling_layout2']);
	$shortcode->add_dependecy('sterling_image', 'template', ['sterling_layout2']);
	$shortcode->add_dependecy('sterling_icon_size', 'template', 'sterling_layout2');

	$shortcode->add_params([
    'sterling_image'     => [
			'type'    => 'attach_images',
			'heading' => esc_html__('Add image', 'sterling'),
		],
		'sterling_all_item' => [
			'type'    => 'switch',
			'heading' => esc_html__('Show all images?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_icon_size' => [
			'type'    => 'text',
			'heading' => esc_html__('Icon font size on hover', 'sterling'),
			'selectors' => ['{{WRAPPER}} .grid-item span::after' => 'font-size: {{VALUE}}']
		],
  ]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'sterling_media_',
		'dependency' => ['template', ['sterling_layout2']]
	]);
}
