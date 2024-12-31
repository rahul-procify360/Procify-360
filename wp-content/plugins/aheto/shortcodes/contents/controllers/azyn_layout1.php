<?php

add_action( 'aheto_before_aheto_contents_register', 'azyn_contents_layout1' );

/**
 * Contents Shortcode
 */

function azyn_contents_layout1( $shortcode ) {

	$theme_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'azyn_layout1', [
		'title' => esc_html__( 'Animated Link', 'azyn' ),
		'image' => $theme_dir . 'azyn_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'azyn_text', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_url', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_use_title_typo', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_title_typo', 'template', 'azyn_layout1' );
	$shortcode->add_dependecy( 'azyn_title_typo', 'azyn_use_title_typo', 'true' );

	$shortcode->add_params( [
		'azyn_text'     => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Text', 'acacio' ),
			'grid'      => 6,
		],
		'azyn_url'  => [
			'type'        => 'link',
			'heading'     => esc_html__( 'URL', 'azyn' ),
			'description' => esc_html__( 'Add url to text.', 'azyn' ),
			'default'     => [
				'url' => '#',
			],
		],
		'azyn_use_title_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Title?', 'azyn' ),
			'grid'    => 12,
			'default' => '',
		],
		'azyn_title_typo' => [
			'type' => 'typography',
			'group' => 'Title Typography',
			'settings' => [
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents--azyn-link-wrap',
		]
	] );

}
function azyn_contents_layout1_dynamic_css( $css, $shortcode ) {
	if ( ! empty( $shortcode->atts['azyn_use_title_typo'] ) && ! empty( $shortcode->atts['azyn_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s a'], $shortcode->parse_typography( $shortcode->atts['azyn_title_typo'] ) );
	}
	return $css;
}
add_filter( 'aheto_contents_dynamic_css', 'azyn_contents_layout1_dynamic_css', 10, 2 );
