<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_heading_register', 'moovit_heading_layout1' );


/**
 * Heading
 */
function moovit_heading_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Heading 14', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_subtitle', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_subtitle_tag', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_use_subtitle_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_use_dot', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_dot_color', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_dot_color', 'moovit_use_dot', 'true' );
	$shortcode->add_dependecy( 'moovit_align_mobile', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_subtitle_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_subtitle_typo', 'moovit_use_subtitle_typo', 'true' );

	aheto_demos_add_dependency( ['text_typo', 'heading', 'alignment', 'source','text_tag', 'use_typo'], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_params( [
		'moovit_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Subtitle', 'moovit' ),
			'description' => esc_html__( 'Add some text for Subtitle', 'moovit' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for Subtitle', 'moovit' ),
		],
		'moovit_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Subtitle', 'moovit' ),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h5',
			'grid'    => 5,
		],
		'moovit_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Subtitle?', 'moovit' ),
			'grid'    => 3,
		],

		'moovit_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'moovit_use_dot'       => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot in the end title?', 'moovit' ),
			'grid'    => 12,
		],
		'moovit_dot_color'     => [
			'type'    => 'select',
			'heading' => esc_html__( 'Color for dot', 'moovit' ),
			'options' => [
				'primary' => esc_html__( 'Primary', 'moovit' ),
				'dark'    => esc_html__( 'Dark', 'moovit' ),
				'white'   => esc_html__( 'White', 'moovit' ),
			],
			'default' => 'primary',
		],

		'moovit_align_mobile' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align for mobile', 'moovit' ),
			'options' => [
				'default' => 'Default',
				'left'    => 'Left',
				'center'  => 'Center',
				'right'   => 'Right',
			],
			'default' => 'default',
		],

	] );

}

function moovit_heading_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_subtitle_typo'] ) && ! empty( $shortcode->atts['moovit_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography( $shortcode->atts['moovit_subtitle_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'moovit_heading_layout1_dynamic_css', 10, 2 );

