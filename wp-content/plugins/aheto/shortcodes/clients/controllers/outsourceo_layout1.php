<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_clients_register', 'outsourceo_clients_layout1' );


/**
 * Clients Shortcode
 */

function outsourceo_clients_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/clients/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Clients 5', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_max_width', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_aside_text', 'template', 'outsourceo_layout1' );

	aheto_demos_add_dependency( ['hover_style', 'clients', 'item_per_row'], [ 'outsourceo_layout1' ], $shortcode );

	$shortcode->add_params( [
		'outsourceo_max_width'  => [
			'type'      => 'slider',
			'heading'   => esc_html__( 'Max width for image section', 'outsourceo' ),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 5,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-clients__wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		],
		'outsourceo_aside_text' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Aside Text', 'outsourceo' ),
		],
	] );
}