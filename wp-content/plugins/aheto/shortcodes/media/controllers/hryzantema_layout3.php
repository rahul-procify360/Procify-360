<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'hryzantema_media_layout3');

/**
 * Simple media
 */

function hryzantema_media_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'hryzantema_layout3', [
		'title' => esc_html__( 'Media 13', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout3.jpg',
	] );

	$shortcode->add_dependecy( 'align', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_image', 'template', 'hryzantema_layout3' );

	$shortcode->add_params([
		'hryzantema_image'     => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Add image', 'hryzantema'),
		],
		'align'             => true,
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', ['hryzantema_layout3'] ]
	]);
}

