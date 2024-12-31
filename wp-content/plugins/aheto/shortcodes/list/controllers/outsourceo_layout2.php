<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'outsourceo_list_layout2' );

/**
 * List Shortcode
 */

function outsourceo_list_layout2( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'outsourceo_layout2', [
		'title' => esc_html__( 'List 20', 'outsourceo' ),
		'image' => $dir . 'moovit_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_lists', 'template', 'outsourceo_layout2' );
	$shortcode->add_dependecy( 'outsourceo_links_color', 'template', 'outsourceo_layout2' );


	$shortcode->add_params( [
		'outsourceo_lists' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Link Lists', 'outsourceo' ),
			'params'  => [
				'outsourceo_link_text' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Text', 'outsourceo' ),
				],
				'outsourceo_link_url'  => [
					'type'        => 'link',
					'heading'     => esc_html__( 'Link', 'outsourceo' ),
					'description' => esc_html__( 'Add url to list.', 'outsourceo' ),
					'default'     => [
						'url' => '#',
					],
				]
			],
		],
		'outsourceo_links_color'   => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links color', 'outsourceo' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-list--outsourceo-links li a' => 'color: {{VALUE}}' ],
		],
	] );
}

function outsourceo_list_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_links_color'] ) ) {
		$color                               = Sanitize::color( $shortcode->atts['color'] );
		$css['global']['%1$s li a']['color'] = $color;
	}

	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'outsourceo_list_layout2_dynamic_css', 10, 2 );