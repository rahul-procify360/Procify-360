<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_video-btn_register', 'pointe_video_btn_layout1' );

/**
 * Testimonials
 */

function pointe_video_btn_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/video-btn/previews/';

	$shortcode->add_layout('pointe_layout1', [
        'title' => esc_html__('Pointe Style', 'pointe'),
        'image' => $preview_dir . 'pointe_layout1.jpg',

    ]);
}