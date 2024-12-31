<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'funero_social_networks_layout1');

/**
 * Social Networks Shortcode
 */

function funero_social_networks_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/social-networks/previews/';
	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Social Networks 4', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);

	aheto_demos_add_dependency('networks', ['funero_layout1'], $shortcode);
	$shortcode->add_dependecy('funero_left', 'template', ['funero_layout1']);
	$shortcode->add_params([
		'funero_left' => [
			'type'    => 'switch',
			'heading' => esc_html__('Align Social Icons to the left side?', 'funero'),
			'grid'    => 3,
		],
	]);
}
