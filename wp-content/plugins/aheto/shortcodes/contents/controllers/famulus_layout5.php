<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'famulus_contents_layout5');


/**
 * Contents
 */

function famulus_contents_layout5($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';
	$shortcode->add_layout('famulus_layout5', [
		'title' => esc_html__('Content 10', 'famulus'),
		'image' => $preview_dir . 'famulus_layout5.jpg',
	]);

	$shortcode->add_dependecy('famulus_icon', 'template', 'famulus_layout5');

	$shortcode->add_params([
		'famulus_icon' => [
			'type'    => 'group',
			'heading' => esc_html__('Icons', 'famulus'),
			'params'  => [
				'famulus_item_title' => [
					'type'    => 'text',
					'heading' => esc_html__('Title', 'famulus'),
				],
			]
		],
	]);
	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon'  => true,
		'prefix'    => 'famulus_',
		'add_label' => esc_html__('Add icon?', 'famulus'),
		'exclude'   => ['align', 'color'],
	], 'famulus_icon');
}
