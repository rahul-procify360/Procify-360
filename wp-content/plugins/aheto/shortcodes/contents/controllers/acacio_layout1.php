<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'acacio_contents_layout1' );


/**
 * Contents
 */

function acacio_contents_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Content 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );

    aheto_demos_add_dependency( ['faqs', 'first_is_opened', 'multi_active', 'title_typo', 'text_typo'], [ 'acacio_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'acacio_size', 'template', 'acacio_layout1' );

	$shortcode->add_params( [
		'acacio_size'     => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Size icon', 'acacio' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-contents__heading i' => 'font-size: {{VALUE}}px' ],
			'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
		],
	] );

    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'exclude'  => ['align'],
        'prefix' => 'acacio_contents1',
        'dependency' => ['template', ['acacio_layout1']]
    ]);
}
function acacio_contents_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['acacio_size'] ) ) {
		$size = Sanitize::size( $shortcode->atts['acacio_size'] );
		$css['global']['%1$s .aheto-contents__heading i']['size'] = $size;
	}

	return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'acacio_contents_layout1_dynamic_css', 10, 2 );


