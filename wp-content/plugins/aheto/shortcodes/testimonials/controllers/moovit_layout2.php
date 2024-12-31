<?php
use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'moovit_testimonials_layout2' );

/**
 * Testimonials
 */

function moovit_testimonials_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Testimonials 18', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_testimonials', 'template', [ 'moovit_layout2' ] );

	$shortcode->add_params( [
		'moovit_testimonials' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Modern Testimonials Items', 'moovit' ),
			'params'  => [
				'moovit_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Display Image', 'moovit' ),
				],
				'moovit_name'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Name', 'moovit' ),
					'default' => esc_html__( 'Author name', 'moovit' ),
				],
				'moovit_company'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Position', 'moovit' ),
					'default' => esc_html__( 'Author position', 'moovit' ),
				],
				'moovit_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Testimonial', 'moovit' ),
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'moovit' ),
				],
			],
		],
	] );
}