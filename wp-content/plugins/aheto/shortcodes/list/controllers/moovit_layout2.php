<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'moovit_list_layout2' );

/**
 * List
 */

function moovit_list_layout2( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'List 14', 'moovit' ),
		'image' => $dir . 'moovit_layout2.jpg',
	] );


	$shortcode->add_dependecy( 'moovit_lists', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_links_color', 'template', 'moovit_layout2' );


	$shortcode->add_params( [
		'moovit_lists' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Link Lists', 'moovit' ),
			'params'  => [
				'moovit_link_text' => [
					'type'    => 'text',
					'heading' => esc_html__( 'Text', 'moovit' ),
				],
				'moovit_link_url'  => [
					'type'        => 'link',
					'heading'     => esc_html__( 'Link', 'moovit' ),
					'description' => esc_html__( 'Add url to list.', 'moovit' ),
					'default'     => [
						'url' => '#',
					],
				]
			],
		],
		'moovit_links_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Links color', 'moovit' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-list--moovit-links li a' => 'color: {{VALUE}}' ],
		],
	] );

}

function moovit_list_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_links_color'] ) ) {
		$color = Sanitize::color( $shortcode->atts['color'] );
		$css['global']['%1$s li a']['color'] = $color;
	}

	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'moovit_list_layout2_dynamic_css', 10, 2 );