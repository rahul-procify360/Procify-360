<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'hryzantema_features_single_layout7');

/**
 * Features Single Shortcode
 */

function hryzantema_features_single_layout7($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'hryzantema_layout7', [
		'title' => esc_html__( 'Features Single 25', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout7.jpg',
	] );
	$shortcode->add_dependecy( 'hr_features_modern_horizontal', 'template', 'hryzantema_layout7' );

	$shortcode->add_params( [
		'hr_features_modern_horizontal' => [
			'type'    => 'group',
			'heading' => esc_html__( 'HR Consult Features Modern (Horizontal)', 'hryzantema' ),
			'params'  => [
				'hryzantema_features_counter_bg'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Add your background image for numbers', 'hryzantema' ),
				],
				'hryzantema_features_title_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Add your title image ', 'hryzantema' ),
				],
				'hryzantema_features_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title', 'hryzantema' ),
					'description' => esc_html__( 'Set your title', 'hryzantema' ),
					'admin_label' => true,
					'default'     => esc_html__( 'Title', 'hryzantema' ),
				],
			]
		],
	]);

}
