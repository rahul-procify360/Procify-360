<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'outsourceo_testimonials_layout3' );


/**
 * Testimonial Shortcode
 */

function outsourceo_testimonials_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'outsourceo_layout3', [
		'title' => esc_html__( 'Testimonials 22', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout3.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_single_testimonial', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_single_image', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_single_name', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_single_company', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_use_position_typo', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_position_typo', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_position_typo', 'outsourceo_use_position_typo', 'true' );

	$shortcode->add_params( [
		'outsourceo_single_testimonial'         => [
			'type'    => 'textarea',
			'heading' => esc_html__( 'Testimonial', 'outsourceo' ),
			'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'outsourceo' ),
		],
		'outsourceo_single_image'               => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Display Image', 'outsourceo' ),
		],
		'outsourceo_single_name'                => [
			'type'    => 'text',
			'heading' => esc_html__( 'Name', 'outsourceo' ),
			'default' => esc_html__( 'Author name', 'outsourceo' ),
		],
		'outsourceo_single_company'             => [
			'type'    => 'text',
			'heading' => esc_html__( 'Position', 'outsourceo' ),
			'default' => esc_html__( 'Author position', 'outsourceo' ),
		],
		'outsourceo_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Position Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
	] );
}


function outsourceo_testimonials_layout3_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_position_typo'] ) && ! empty( $shortcode->atts['outsourceo_position_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography( $shortcode->atts['outsourceo_position_typo'] ) );
	}


	return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'outsourceo_testimonials_layout3_shortcode_dynamic_css', 10, 2 );