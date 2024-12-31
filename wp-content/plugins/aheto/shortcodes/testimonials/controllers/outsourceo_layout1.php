<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'outsourceo_testimonials_layout1' );


/**
 * Testimonial Shortcode
 */

function outsourceo_testimonials_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Testimonials 20', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_testimonial_item', 'template', ['outsourceo_layout1'] );
	
	$shortcode->add_dependecy( 'outsourceo_use_blockquote_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_blockquote_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_blockquote_typo', 'outsourceo_use_blockquote_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_use_text_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_text_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_text_typo', 'outsourceo_use_text_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_use_name_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_name_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_name_typo', 'outsourceo_use_name_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_background', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_border', 'template', 'outsourceo_layout1' );

	$shortcode->add_params( [
		'outsourceo_testimonial_item'           => [
			'type'    => 'group',
			'heading' => esc_html__( 'Testimonials', 'outsourceo' ),
			'params'  => [
				'g_blockquote'  => [
					'type'    => 'text',
					'heading' => esc_html__( 'Blockquote', 'outsourceo' ),
					'default' => esc_html__( 'Blockquote', 'outsourceo' ),
				],
				'g_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Testimonial', 'outsourceo' ),
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'outsourceo' ),
				],
				'g_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Display Image', 'outsourceo' ),
				],
				'g_name'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Name', 'outsourceo' ),
					'default' => esc_html__( 'Author name', 'outsourceo' ),
				],
				'g_company'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Position', 'outsourceo' ),
					'default' => esc_html__( 'Author position', 'outsourceo' ),
				],
			],
		],
		'outsourceo_use_blockquote_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for blockquote?', 'outsourceo' ),
			'grid'    => 6,
		],
		'outsourceo_blockquote_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Blockquote Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__blockquote',
		],
		'outsourceo_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Outsourceo Blockquote Background Color', 'outsourceo' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-tm__blockquote' => 'background: {{VALUE}}',
			],
		],
		'outsourceo_border' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Outsourceo Blockquote Border Color', 'outsourceo' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-tm__blockquote' => 'border-color: {{VALUE}}',
			],
		],
		'outsourceo_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for testimonials?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Testimonials Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'outsourceo_use_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Name?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_name_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Name Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		]
	] );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'outsourceo_swiper_',
		'include'        => [
			'pagination',
			'speed',
			'loop',
			'autoplay',
			'spaces',
			'slides',
			'simulate_touch'
		],
		'dependency'     => [ 'template', [ 'outsourceo_layout1' ] ]
	] );
}


function outsourceo_testimonials_layout1_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_blockquote_typo'] ) && ! empty( $shortcode->atts['outsourceo_blockquote_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__blockquote'], $shortcode->parse_typography( $shortcode->atts['outsourceo_blockquote_typo'] ) );
	}
	

	if ( isset( $shortcode->atts['outsourceo_background'] ) && ! empty( $shortcode->atts['outsourceo_background'] ) ) {
		$color                               = Sanitize::color( $shortcode->atts['outsourceo_background'] );
		$css['global']['%1$s']['background'] = $color;
	}

	if ( isset( $shortcode->atts['outsourceo_border'] ) && ! empty( $shortcode->atts['outsourceo_border'] ) ) {
		$color                               = Sanitize::color( $shortcode->atts['outsourceo_border'] );
		$css['global']['%1$s']['border-color'] = $color;
	}

	if ( ! empty( $shortcode->atts['outsourceo_use_text_typo'] ) && ! empty( $shortcode->atts['outsourceo_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['outsourceo_text_typo'] ) );
	}

	if (isset( $shortcode->atts['outsourceo_use_name_typo'] ) && $shortcode->atts['outsourceo_use_name_typo'] && isset($shortcode->atts['outsourceo_name_typo']) && ! empty( $shortcode->atts['outsourceo_name_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography( $shortcode->atts['outsourceo_name_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'outsourceo_testimonials_layout1_shortcode_dynamic_css', 10, 2 );