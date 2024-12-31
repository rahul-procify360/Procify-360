<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'mooseoom_features_single_layout1' );

/**
 * Features Single
 */

function mooseoom_features_single_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Features Single 33', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['s_heading', 'use_heading', 't_heading', 's_description', 's_image', 'use_description', 't_description'], [ 'mooseoom_layout1'], $shortcode );

	$shortcode->add_dependecy('mooseoom_align', 'template', 'mooseoom_layout1');

	$shortcode->add_params( [
		'mooseoom_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'mooseoom'),
			'options' => \Aheto\Helper::choices_alignment(),
		],

	] );
}