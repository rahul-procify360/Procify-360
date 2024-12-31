<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'moovit_banner_slider_layout2' );

/**
 *  Banner Slider
 */

function moovit_banner_slider_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Banner Slider 17', 'aheto' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_creative_banners', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_dot_color', 'moovit_use_dot', 'true' );

	aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'moovit_layout2' ], $shortcode );

	$shortcode->add_params( [

		'moovit_creative_banners' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Banners', 'aheto' ),
			'params'  => [
				'moovit_image'     => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'aheto' ),
				],
				'moovit_add_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Additional Image', 'aheto' ),
				],
				'moovit_title'     => [
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Title', 'aheto' ),
					'description' => esc_html__( 'For adding big point insert title use {{.}}, but do not use {{.}} in the end of title. For example: Lorem{{.}} Ipsum', 'aheto' ),
				],
				'align'             => [
					'type'    => 'select',
					'heading' => esc_html__( 'Align', 'aheto' ),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'moovit_use_dot'   => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Use dot in the end title?', 'aheto' ),
					'grid'    => 12,
				],
				'moovit_dot_color' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Color for dot', 'aheto' ),
					'options' => [
						'primary' => esc_html__( 'Primary', 'aheto' ),
						'dark'    => esc_html__( 'Dark', 'aheto' ),
						'white'   => esc_html__( 'White', 'aheto' ),
					],
					'default' => 'primary',
				],
			]
		],
	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'moovit_main_',
	], 'moovit_creative_banners' );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'moovit_swiper_',
		'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'arrows_color', 'arrows_size'  ],
		'dependency'     => [ 'template', [ 'moovit_layout2' ] ]
	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Additional image size', 'aheto' ),
		'prefix'     => 'moovit_',
		'dependency' => ['template', ['moovit_layout2']]
	]);

}


function moovit_banner_slider_layout2_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['moovit_swiper_arrows_color']) ) {
		$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['moovit_swiper_arrows_color']);
	}

	if ( !empty($shortcode->atts['moovit_swiper_arrows_size']) ) {
		$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['moovit_swiper_arrows_size'] );
	}

	return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'moovit_banner_slider_layout2_dynamic_css', 10, 2 );