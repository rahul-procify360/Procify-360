<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'moovit_custom_post_types_layout1' );

/**
 * Custom Post Type
 */

function moovit_custom_post_types_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/custom-post-types/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Custom Post Type 12', 'moovit' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );


	$shortcode->add_dependecy( 'moovit_background_type', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_background', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_image', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_small_image', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_background', 'moovit_background_type', 'color' );
	$shortcode->add_dependecy( 'moovit_image', 'moovit_background_type', 'image' );

	aheto_demos_add_dependency( ['skin', 'use_heading', 't_heading', 'use_term', 't_term', 'image_height', 'title_tag' ], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_params( [
		'moovit_background_type' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Shape background type', 'moovit' ),
			'options' => [
				'color' => esc_html__( 'Color', 'moovit' ),
				'image' => esc_html__( 'Image', 'moovit' ),
			],
			'default' => 'color',
		],

		'moovit_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Shape background color', 'moovit' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .moovit-shape' => 'background: {{VALUE}}' ],
		],

		'moovit_image' => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Shape background image', 'moovit' ),
		],

		'moovit_small_image' => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Small bottom image', 'moovit' ),
		],

	] );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'moovit_swiper_',
		'include'        => [ 'effect', 'pagination', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch',  'arrows_color', 'arrows_size', 'slides', 'spaces' ],
		'dependency'     => [ 'template', [ 'moovit_layout1' ] ]
	] );

}

function moovit_cpt_image_sizer_layout1( $image_sizer_layouts ) {

	$image_sizer_layouts[] = 'moovit_layout1';

	return $image_sizer_layouts;
}

add_filter( 'aheto_cpt_image_sizer_layouts', 'moovit_cpt_image_sizer_layout1', 10, 2 );


function moovit_cpt_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_background'] ) && $shortcode->atts['moovit_background_type'] == 'color' ) {
		$css['global']['%1$s .moovit-shape']['background'] = \Aheto\Sanitize::color( $shortcode->atts['moovit_background'] );
	}

	if ( !empty($shortcode->atts['moovit_swiper_arrows_color']) ) {
		$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['moovit_swiper_arrows_color']);
	}

	if ( !empty($shortcode->atts['moovit_swiper_arrows_size']) ) {
		$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['moovit_swiper_arrows_size'] );
	}


	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'moovit_cpt_layout1_dynamic_css', 10, 2 );