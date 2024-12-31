<?php

use Aheto\Helper;

add_action('aheto_before_aheto_video-btn_register', 'djo_video_btn_layout2');

/**
 * Video Button Shortcode
 */

function djo_video_btn_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/video-btn/previews/';

	$shortcode->add_layout('djo_layout2', [
		'title' => esc_html__('Video Button 2', 'djo'),
		'image' => $preview_dir . 'djo_layout2.jpg',
	]);

	$shortcode->add_dependecy('djo_title', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_image', 'template', 'djo_layout2');

	$shortcode->add_params([
		'djo_title'        => [
			'type'    => 'text',
			'heading' => esc_html__('Seo title(For Video Poster Image)', 'djo'),
		],
		'djo_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Preview Image', 'djo'),
			'description' => esc_html__('If this empty - will be show Video Poster Image', 'djo'),
		],
	]);
}
