<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'djo_features_single_layout3');

/**
 * Features Single Shortcode
 */

function djo_features_single_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout('djo_layout3', [
		'title' => esc_html__('Features Single 7', 'djo'),
		'image' => $preview_dir . 'djo_layout3.jpg',
	]);

	aheto_demos_add_dependency(['s_image', 's_heading','use_heading', 't_heading','s_description','use_description', 't_description'], ['djo_layout3'], $shortcode);

}