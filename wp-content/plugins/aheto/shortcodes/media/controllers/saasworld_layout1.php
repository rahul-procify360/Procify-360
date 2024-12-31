<?php
use Elementor\Modules\DynamicTags\Module as TagsModule;
use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'saasworld_media_layout1');


/**
 * Media Shortcode
 */

function saasworld_media_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('saasworld_layout1', [
		'title' => esc_html__('Saasworld Video', 'saasworld'),
		'image' => $preview_dir . 'saasworld_layout1.jpg',
	]);

	$shortcode->add_dependecy('saasworld_image_video', 'template', 'saasworld_layout1');
	$shortcode->add_dependecy('saasworld_video_link', 'template', 'saasworld_layout1');
	$shortcode->add_dependecy('saasworld_hide_video', 'template', 'saasworld_layout1');
	$shortcode->add_dependecy('saasworld_image_video', 'saasworld_hide_video', 'true');



	$shortcode->add_params([
		'saasworld_video_link'  => [
			'type'    => 'text',
			'heading' => esc_html__('Video Link', 'saasworld'),
		],
		'saasworld_hide_video'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Hide video on mobile?', 'saasworld'),
			'grid'    => 3,
		],
		'saasworld_image_video' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Image on mobile', 'saasworld'),
		],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'saasworld_',
		'dependency' => ['template', 'saasworld_layout1']
	]);

}

