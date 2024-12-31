<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'azyn_contents_layout4' );


/**
 * Contents
 */

function azyn_contents_layout4( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';


	$shortcode->add_layout( 'azyn_layout4', [
		'title' => esc_html__( 'Interactive links', 'azyn' ),
		'image' => $preview_dir . 'azyn_layout4.jpg',
	] );

	$shortcode->add_dependecy( 'azyn_interactive_items', 'template', 'azyn_layout4' );
	$shortcode->add_dependecy( 'azyn_interactive_item_active', 'template', 'azyn_layout4' );
	$shortcode->add_dependecy( 'azyn_use_interactive_typo', 'template', 'azyn_layout4' );
	$shortcode->add_dependecy( 'azyn_interactive_typo', 'template', 'azyn_layout4' );
	$shortcode->add_dependecy( 'azyn_interactive_typo', 'azyn_use_interactive_typo', 'true' );

	$shortcode->add_dependecy( 'azyn_use_interactive_num_typo', 'template', 'azyn_layout4' );
	$shortcode->add_dependecy( 'azyn_interactive_num_typo', 'template', 'azyn_layout4' );
	$shortcode->add_dependecy( 'azyn_interactive_num_typo', 'azyn_use_interactive_num_typo', 'true' );


	$shortcode->add_params( [

		'azyn_interactive_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Links', 'azyn' ),
			'params'  => [
				'azyn_interactive_title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'azyn' ),
				],
				'azyn_interactive_url'  => [
					'type'        => 'link',
					'heading'     => esc_html__( 'URL', 'azyn' ),
					'description' => esc_html__( 'Add url to title.', 'azyn' ),
					'default'     => [
						'url' => '#',
					],
				],
				'azyn_interactive_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'azyn' ),
				],

			]
		],

		'azyn_interactive_item_active'       => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Active color for text', 'azyn' ),
			'grid'      => 6,
			'default'   => '',
			'selectors' => [
				'{{WRAPPER}} .owl-item.active.center .aheto-contents__slide a' => 'color: {{VALUE}}!important',
			],
		],

		'azyn_use_interactive_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for text?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_interactive_typo' => [
			'type'     => 'typography',
			'group'    => 'Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__slide a',
		],
		'azyn_use_interactive_num_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for numbers?', 'azyn' ),
			'grid'    => 3,
		],
		'azyn_interactive_num_typo' => [
			'type'     => 'typography',
			'group'    => 'Numbers Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .img-item .num',
		],

	] );

}
