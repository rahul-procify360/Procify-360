<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_video-btn_register', 'mooseoom_video_btn_layout1' );

/**
 * Testimonials
 */

function mooseoom_video_btn_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/video-btn/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Video Button 5', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	] );


	$shortcode->add_dependecy('mooseoom_video_btn_image', 'template', 'mooseoom_layout1');

	$shortcode->add_params( [
		'mooseoom_video_btn_image' => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Preview image for video', 'mooseoom')
		],
	] );
}