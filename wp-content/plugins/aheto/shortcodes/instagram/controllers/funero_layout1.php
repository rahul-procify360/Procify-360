<?php

use Aheto\Helper;

add_action('aheto_before_aheto_instagram_register', 'funero_instagram_layout1');

/**
 * Funero Instagram
 */

function funero_instagram_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/instagram/previews/';
	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Instagram 2', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);
}