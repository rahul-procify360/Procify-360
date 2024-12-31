<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'hryzantema_media_layout1');

/**
 * Simple media
 */

function hryzantema_media_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('hryzantema_layout1', [
		'title' => esc_html__('Media 11', 'hryzantema'),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	]);
	$shortcode->add_dependecy('hryzantema_image', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_max_width_hide', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('align', 'template', 'hryzantema_layout1');
	$shortcode->add_params([
		'hryzantema_image'          => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Add image', 'hryzantema'),
		],
		'hryzantema_max_width_hide' => [
			'type'    => 'slider',
			'heading' => esc_html__('Hide image on width', 'hryzantema'),
			'grid'    => 12,
			'range'   => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 1,
				],
			],
		],
		'align'             => true,
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [ 'hryzantema_layout1'] ]
	]);
}

