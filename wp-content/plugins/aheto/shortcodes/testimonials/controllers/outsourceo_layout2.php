<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'outsourceo_testimonials_layout2' );


/**
 * Testimonial Shortcode
 */

function outsourceo_testimonials_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Testimonials 21', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_bg_text', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_dark_version', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_testimonials_creative_item', 'template', 'outsourceo_layout2' );

	$shortcode->add_dependecy( 'outsourceo_use_bg_text_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_bg_text_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_bg_text_typo', 'outsourceo_use_bg_text_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_use_text_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_text_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_text_typo', 'outsourceo_use_text_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_use_name_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_name_typo', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_name_typo', 'outsourceo_use_name_typo', 'true' );

	$shortcode->add_params( [
		'outsourceo_dark_version'               => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark version?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_bg_text'                    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Background text', 'outsourceo' ),
			'default' => esc_html__( 'THEY SAY', 'outsourceo' ),
		],
		'outsourceo_testimonials_creative_item' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Modern Testimonials Items', 'outsourceo' ),
			'params'  => [
				'outsourceo_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Display Image', 'outsourceo' ),
				],
				'outsourceo_name'        => [
					'type'    => 'text',
					'heading' => esc_html__( 'Name', 'outsourceo' ),
					'default' => esc_html__( 'Author name', 'outsourceo' ),
				],
				'outsourceo_company'     => [
					'type'    => 'text',
					'heading' => esc_html__( 'Position', 'outsourceo' ),
					'default' => esc_html__( 'Author position', 'outsourceo' ),
				],
				'outsourceo_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Testimonial', 'outsourceo' ),
					'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'outsourceo' ),
				],
			],
		],
		'outsourceo_use_bg_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for background text?', 'moovit' ),
			'grid'    => 3,
		],
		'outsourceo_bg_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Background Text Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__bg-text',
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
		'dependency'     => [ 'template', [ 'outsourceo_layout2' ] ]
	] );


}

function outsourceo_testimonials_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_bg_text_typo'] ) && ! empty( $shortcode->atts['outsourceo_bg_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__bg-text'], $shortcode->parse_typography( $shortcode->atts['outsourceo_bg_text_typo'] ) );
	}

	if (isset( $shortcode->atts['outsourceo_use_text_typo'] ) && $shortcode->atts['outsourceo_use_text_typo'] && isset($shortcode->atts['outsourceo_text_typo']) && ! empty( $shortcode->atts['outsourceo_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['outsourceo_text_typo'] ) );
	}

	if (isset( $shortcode->atts['outsourceo_use_name_typo'] ) && $shortcode->atts['outsourceo_use_name_typo'] && isset($shortcode->atts['outsourceo_name_typo']) && ! empty( $shortcode->atts['outsourceo_name_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['outsourceo_name_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'outsourceo_testimonials_layout2_dynamic_css', 10, 2 );