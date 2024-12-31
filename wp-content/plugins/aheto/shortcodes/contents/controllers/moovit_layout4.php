<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'moovit_contents_layout4' );


/**
 * Contents
 */

function moovit_contents_layout4( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'moovit_layout4', [
		'title' => esc_html__( 'Content 22', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout4.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_custom_link_items', 'template', 'moovit_layout4' );
	$shortcode->add_dependecy( 'moovit_use_custom_link_typo', 'template', 'moovit_layout4' );
	$shortcode->add_dependecy( 'moovit_custom_link_typo', 'template', 'moovit_layout4' );
	$shortcode->add_dependecy( 'moovit_custom_link_typo', 'moovit_use_custom_link_typo', 'true' );

	$shortcode->add_params( [
		'moovit_custom_link_items'   => [
			'type'    => 'group',
			'heading' => esc_html__( 'Links', 'moovit' ),
			'params'  => [
				'moovit_link_item_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'moovit' ),
				],
				'moovit_item_title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'moovit' ),
				],
				'moovit_link_item_url'  => [
					'type'        => 'link',
					'heading'     => esc_html__( 'URL', 'moovit' ),
					'description' => esc_html__( 'Add url to item.', 'moovit' ),
					'default'     => [
						'url' => '#',
					],
				]

			]
		],
		'moovit_use_custom_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for links?', 'moovit' ),
			'grid'    => 6,
		],
		'moovit_custom_link_typo' => [
			'type'     => 'typography',
			'group'    => 'Moovit Custom Links Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__item a',
		],
	] );


	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', [ 'moovit_layout4'] ]
	]);


}

function moovit_contents_layout4_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_custom_link_typo'] ) && ! empty( $shortcode->atts['moovit_custom_link_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-contents__item a, %1$s .aheto-contents__item a:hover'], $shortcode->parse_typography( $shortcode->atts['moovit_custom_link_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'moovit_contents_layout4_dynamic_css', 10, 2 );

