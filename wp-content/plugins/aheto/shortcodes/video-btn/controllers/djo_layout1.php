<?php

use Aheto\Helper;

add_action('aheto_before_aheto_video-btn_register', 'djo_video_btn_layout1');

/**
 * Video Button Shortcode
 */

function djo_video_btn_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/video-btn/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Video Button 1', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);
}
