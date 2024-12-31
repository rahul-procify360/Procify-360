<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'acacio_features_single_layout1' );

/**
 * Features Single
 */

function acacio_features_single_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Features Single 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['s_heading', 'use_heading', 't_heading', 's_description', 's_image', 'use_description', 't_description'], [ 'acacio_layout1'], $shortcode );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
        'dependency' => ['template', [ 'acacio_layout1'] ]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for images ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout1'] ]
    ]);
}