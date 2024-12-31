<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'hryzantema_media_layout2');

/**
 * Simple media
 */

function hryzantema_media_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'hryzantema_layout2', [
		'title' => esc_html__( 'Media 12', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'align', 'template', 'hryzantema_layout2' );
	$shortcode->add_dependecy( 'hryzantema_video_slider', 'template', 'hryzantema_layout2' );

	$shortcode->add_params([
		'hryzantema_video_slider' => [
			'type'    => 'group',
			'heading' => esc_html__( 'HR Consult Video Slider', 'hryzantema' ),
			'params'  => [
				'hryzantema_video_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'hryzantema' ),
				],
			]
		],
		'align'             => true,
	]);
	\Aheto\Params::add_video_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add video?', 'hryzantema' ),
		'prefix'    => 'hryzantema_',
		'group'     => esc_html__( 'Hryzantema Video Content', 'hryzantema' ),
	], 'hryzantema_video_slider' );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'hryzantema_swiper_',
		'include'        => [ 'effect', 'speed', 'loop', 'autoplay','lazy', 'slides', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'hryzantema_layout2' ] ],
		'group'      => esc_html__( 'Hryzantema Swiper', 'hryzantema' ),

	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [ 'hryzantema_layout2'] ]
	]);
}

