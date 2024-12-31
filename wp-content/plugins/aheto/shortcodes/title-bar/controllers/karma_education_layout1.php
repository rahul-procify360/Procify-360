<?php

use Aheto\Helper;

add_action('aheto_before_aheto_title-bar_register', 'karma_education_title_bar_layout1');

/**
 * Title Bar Shortcode
 */

function karma_education_title_bar_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/title-bar/previews/';

	$shortcode->add_layout( 'karma_education_layout1', [
		'title' => esc_html__( 'Title Bar 4', 'karma_education' ),
		'image' => $preview_dir . 'karma_education_layout1.jpg',
	] );

	aheto_demos_add_dependency(['searchform'], ['karma_education_layout1'], $shortcode);
}

