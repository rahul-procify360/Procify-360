<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'hryzantema_contents_layout2');

/**
 * Contents Shortcode
 */

function hryzantema_contents_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout('hryzantema_layout2', [
		'title' => esc_html__('Content 16', 'hryzantema'),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	]);

	$shortcode->add_dependecy('hryzantema_creative_items', 'template', 'hryzantema_layout2');
	$shortcode->add_dependecy('hryzantema_creative_version', 'template', 'hryzantema_layout2');
	$shortcode->add_params([
		'hryzantema_creative_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Slides', 'hryzantema' ),
			'params'  => [
				'hryzantema_item_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'hryzantema' ),
				],
				'hryzantema_item_title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'hryzantema' ),
				],
				'hryzantema_item_use_dot'       => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Use dot in the end title?', 'hryzantema' ),
					'grid'    => 12,
				],
				'hryzantema_item_dot_color'     => [
					'type'    => 'select',
					'heading' => esc_html__( 'Color for dot', 'hryzantema' ),
					'options' => [
						'primary' => esc_html__( 'Primary', 'hryzantema' ),
						'dark'    => esc_html__( 'Dark', 'hryzantema' ),
						'white'   => esc_html__( 'White', 'hryzantema' ),
					],
					'default' => 'primary',
				],
				'hryzantema_item_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'hryzantema' ),
				],
				'hryzantema_item_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'hryzantema' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'hryzantema' ),
						'is-vertical' => esc_html__( 'Vertical', 'hryzantema' ),
					],
				],
			]
		],
		'hryzantema_creative_version' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable creative version?', 'hryzantema' ),
			'grid'    => 3,
		],

	]);
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
		'icons'  => true,
	], 'hryzantema_creative_items' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add additional button?', 'hryzantema' ),
		'prefix'    => 'hryzantema_add_',
		'icons'     => true,
	], 'hryzantema_creative_items' );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'hryzantema_swiper_',
		'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch' ],
		'dependency'     => [ 'template', [ 'hryzantema_layout2' ] ],
		'group'      => esc_html__( 'Hryzantema Swiper', 'hryzantema' ),
	] );

}
