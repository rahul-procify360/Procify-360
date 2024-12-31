<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_media_register', 'moovit_media_layout1' );


/**
 * Media Shortcode
 */

function moovit_media_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Media 16', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );


	$shortcode->add_dependecy( 'moovit_left_small_image', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_right_small_image', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_background_type', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_background', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_background', 'moovit_background_type', 'color' );
	$shortcode->add_dependecy( 'moovit_image', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_image', 'moovit_background_type', 'image' );
	$shortcode->add_dependecy( 'moovit_modern_items', 'template', 'moovit_layout1' );


	$shortcode->add_params( [
		'moovit_left_small_image'  => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Left small image', 'moovit' ),
		],
		'moovit_right_small_image' => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Right small image', 'moovit' ),
		],
		'moovit_background_type'   => [
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

		'moovit_modern_items' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Slides', 'moovit' ),
			'params'  => [
				'moovit_item_video_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Preview image for video', 'moovit' ),
				],
			]
		],

	] );

	\Aheto\Params::add_video_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add video?', 'moovit' ),
		'prefix'    => 'moovit_',
		'group'     => esc_html__( 'Video Content', 'moovit' ),
	], 'moovit_modern_items' );


	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'moovit_swiper_',
		'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'moovit_layout1' ] ]
	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', [ 'moovit_layout1'] ]
	]);

}


function moovit_media_layout1_dynamic_css( $css, $shortcode ) {

	if ( $shortcode->atts['moovit_background_type'] == 'color' && ! empty( $shortcode->atts['moovit_background'] ) ) {
		$color                                             = Sanitize::color( $shortcode->atts['moovit_background'] );
		$css['global']['%1$s .moovit-shape']['background'] = $color;
	}

	return $css;
}

add_filter( 'aheto_media_dynamic_css', 'moovit_media_layout1_dynamic_css', 10, 2 );
