<?php

use Aheto\Helper;

add_action('aheto_before_aheto_instagram_register', 'hryzantema_instagram_layout1');

/**
 * HR Consult Instagram
 */

function hryzantema_instagram_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/instagram/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Instagram 3', 'hryzantema' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

	aheto_demos_add_dependency(['limit', 'size'], ['hryzantema_layout1'], $shortcode);

}

