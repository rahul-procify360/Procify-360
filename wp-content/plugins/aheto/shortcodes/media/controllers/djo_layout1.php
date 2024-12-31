<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'djo_media_layout1');

/**
 * Gallery / Media Shortcode
 */

function djo_media_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Media 4', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);


	aheto_demos_add_dependency( ['image_popup'], [ 'djo_layout1' ], $shortcode );

	$shortcode->add_dependecy('djo_items', 'template', 'djo_layout1');

	$shortcode->add_params([
		'djo_items'        => [
			'type'    => 'group',
			'heading' => esc_html__('Gallery items', 'djo'),
			'params'  => [
				'djo_image'			=> [
					'type'    		=> 'attach_image',
					'heading' 		=> esc_html__('Gallery item image', 'djo'),
				],
				'djo_title'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Gallery item title', 'djo'),
					'grid'    => 12,
				],
				'djo_subtitle'     => [
					'type'    => 'textarea',
					'heading' => esc_html__('Gallery item subtitle', 'djo'),
					'grid'    => 12,
				],
			],
		],
	]);
}
