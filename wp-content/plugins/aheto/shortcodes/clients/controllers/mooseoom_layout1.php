<?php

use Aheto\Helper;

add_action('aheto_before_aheto_clients_register', 'mooseoom_clients_layout1');

/**
 *  Banner Slider
 */

function mooseoom_clients_layout1($shortcode)
{
	$preview_dir = '//assets.aheto.co/clients/previews/';

	$shortcode->add_layout('mooseoom_layout1', [
		'title' => esc_html__('Clients 4', 'mooseoom'),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	]);

	aheto_demos_add_dependency( ['hover_style', 'clients', 'item_per_row'], ['mooseoom_layout1' ], $shortcode );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'         => 'mooseoom_',
		'dependency' => ['template',  ['mooseoom_layout1' ]]
	]);
}
