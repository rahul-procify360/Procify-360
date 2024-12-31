<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'hryzantema_features_single_layout1');

/**
 * Features Single Shortcode
 */

function hryzantema_features_single_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Features Single 19', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_demos_add_dependency(['s_image',	's_heading', 'use_heading', 's_description', 'use_description', 't_heading', 't_description'],  ['hryzantema_layout1'], $shortcode);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [ 'hryzantema_layout1' ] ],
	]);
}
