<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'bizy_testimonials_layout2' );

/**
 * Testimonials
 */

function bizy_testimonials_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'bizy_layout2', [
		'title' => esc_html__( 'Bizy Single', 'bizy' ),
		'image' => $preview_dir . 'bizy_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'bizy_n', 'template', [ 'bizy_layout2' ] );
	$shortcode->add_dependecy( 'bizy_c', 'template', [ 'bizy_layout2' ] );
	$shortcode->add_dependecy( 'bizy_t', 'template', [ 'bizy_layout2' ] );

	$shortcode->add_params( [
		'bizy_t' => [
			'type'    => 'textarea',
			'heading' => esc_html__( 'Testimonial', 'bizy' ),
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'bizy' ),
		],
		'bizy_n'        => [
			'type'    => 'text',
			'heading' => esc_html__( 'Name', 'bizy' ),
			'default' => esc_html__( 'Author name', 'bizy' ),
		],
		'bizy_c'     => [
			'type'    => 'text',
			'heading' => esc_html__( 'Position', 'bizy' ),
			'default' => esc_html__( 'Author position', 'bizy' ),
		]
	] );

}