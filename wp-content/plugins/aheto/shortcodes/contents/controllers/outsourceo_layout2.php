<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'outsourceo_contents_layout2' );

/**
 * Contents Shortcode
 */

function outsourceo_contents_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'Content 26', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout2.jpg',
	] );


	$shortcode->add_dependecy( 'outsourceo_creative_items', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_creative_version', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_br_buttons', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_br_buttons', 'outsourceo_creative_version', 'true' );

	$shortcode->add_params( [
		'outsourceo_creative_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Slides', 'outsourceo' ),
			'params'  => [
				'outsourceo_item_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'outsourceo' ),
				],
				'outsourceo_item_title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'outsourceo' ),
				],
				'outsourceo_item_use_dot'       => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Use dot at the end of the title?', 'outsourceo' ),
					'grid'    => 12,
				],
				'outsourceo_item_dot_color'     => [
					'type'    => 'select',
					'heading' => esc_html__( 'Color for dot', 'outsourceo' ),
					'options' => [
						'primary' => esc_html__( 'Primary', 'outsourceo' ),
						'dark'    => esc_html__( 'Dark', 'outsourceo' ),
						'white'   => esc_html__( 'White', 'outsourceo' ),
					],
					'default' => 'primary',
				],
				'outsourceo_item_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'outsourceo' ),
				],
				'outsourceo_item_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'outsourceo' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'outsourceo' ),
						'is-vertical' => esc_html__( 'Vertical', 'outsourceo' ),
					],
				],
			]
		],
		'outsourceo_creative_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable creative version?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_br_buttons' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Remove border-radius from buttons?', 'outsourceo' ),
			'grid'    => 3,
		],

	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'outsourceo_main_',
		'icons'      => true,
		'add_button' => true,
	], 'outsourceo_creative_items' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label'  => esc_html__( 'Add additional button?', 'outsourceo' ),
		'prefix'     => 'outsourceo_add_',
		'icons'      => true,
		'add_button' => true,
	], 'outsourceo_creative_items' );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'outsourceo_swiper_',
		'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'arrows_size' ],
		'dependency'     => [ 'template', [ 'outsourceo_layout2' ] ]
	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout2' ] ]
	] );
}
