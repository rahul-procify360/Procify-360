<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_video-btn_register', 'ninedok_video_btn_layout1' );
/**
 * Video Button
 */

function ninedok_video_btn_layout1 ( $shortcode )
{
	$dir = '//assets.aheto.co/video-btn/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Video Button 6', 'ninedok' ),
		'image' => $dir . 'ninedok_layout1.jpg',
	] );
}
