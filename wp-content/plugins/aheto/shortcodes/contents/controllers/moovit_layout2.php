<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'moovit_contents_layout2' );


/**
 * Contents
 */

function moovit_contents_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';


	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Content 20', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_creative_items', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_creative_version', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_item_dot_color', 'moovit_item_use_dot', 'true' );

	$shortcode->add_params( [
		'moovit_creative_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Slides', 'moovit' ),
			'params'  => [
				'moovit_item_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'moovit' ),
				],
				'moovit_item_title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'moovit' ),
				],
				'moovit_item_use_dot'       => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Use dot at the end of the title?', 'moovit' ),
					'grid'    => 12,
				],
				'moovit_item_dot_color'     => [
					'type'    => 'select',
					'heading' => esc_html__( 'Color for dot', 'moovit' ),
					'options' => [
						'primary' => esc_html__( 'Primary', 'moovit' ),
						'dark'    => esc_html__( 'Dark', 'moovit' ),
						'white'   => esc_html__( 'White', 'moovit' ),
					],
					'default' => 'primary',
				],
				'moovit_item_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'moovit' ),
				],
				'moovit_item_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'moovit' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'moovit' ),
						'is-vertical' => esc_html__( 'Vertical', 'moovit' ),
					],
				],
			]
		],
		'moovit_creative_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable creative version?', 'moovit' ),
			'grid'    => 3,
		],

	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'moovit_main_',
		'icons'  => true,
	], 'moovit_creative_items' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add additional button?', 'moovit' ),
		'prefix'    => 'moovit_add_',
		'icons'     => true,
	], 'moovit_creative_items' );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'moovit_swiper_',
		'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'moovit_layout2' ] ]
	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', [ 'moovit_layout2'] ]
	]);
}


