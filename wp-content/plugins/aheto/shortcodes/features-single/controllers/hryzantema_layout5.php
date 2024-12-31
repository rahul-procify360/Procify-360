<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'hryzantema_features_single_layout5');

/**
 * Features Single Shortcode
 */

function hryzantema_features_single_layout5($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'hryzantema_layout5', [
		'title' => esc_html__( 'Features Single 23', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout5.jpg',
	] );
	aheto_demos_add_dependency(['s_image','s_heading', 'use_heading', 's_description', 'use_description', 't_heading', 't_description'], ['hryzantema_layout5'], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_heading_tag', 'template', ['hryzantema_layout5'] );
	$shortcode->add_dependecy( 'hryzantema_active', 'template', [ 'hryzantema_layout5'] );

	$shortcode->add_dependecy( 'hryzantema_add_subtitle', 'template', 'hryzantema_layout5' );
	$shortcode->add_dependecy( 'hryzantema_subtitle', 'template', 'hryzantema_layout5' );
	$shortcode->add_dependecy( 'hryzantema_subtitle', 'hryzantema_add_subtitle', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_subtitle_typo', 'template', 'hryzantema_layout5' );
	$shortcode->add_dependecy( 'hryzantema_subtitle_typo', 'template', 'hryzantema_layout5' );
	$shortcode->add_dependecy( 'hryzantema_subtitle_typo', 'hryzantema_use_subtitle_typo', 'true' );

	$shortcode->add_params( [
		'hryzantema_active'     => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Mark as active?', 'hryzantema' ),
			'grid'    => 12,
		],
		'hryzantema_heading_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for heading', 'hryzantema' ),
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
		'hryzantema_add_subtitle' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use subtitle?', 'hryzantema' ),
		],
		'hryzantema_subtitle' => [
			'type'     => 'textarea',
			'heading' => esc_html__( 'Add your subtitle', 'hryzantema' ),
			'grid' => '3',
		],
		'hryzantema_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-block__subtitle',
		],
	]);
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
		'icons' => true,
		'dependency' => ['template', ['hryzantema_layout5'] ],
		'group'      => esc_html__( 'Hryzantema Button', 'hryzantema' ),
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', ['hryzantema_layout5'] ]
	]);
}

function hryzantema_features_single_layout5_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_subtitle_typo'] ) && $shortcode->atts['hryzantema_use_subtitle_typo'] && isset( $shortcode->atts['hryzantema_subtitle_typo'] ) && ! empty( $shortcode->atts['hryzantema_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-content-block__subtitle'], $shortcode->parse_typography( $shortcode->atts['hryzantema_subtitle_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'hryzantema_features_single_layout5_dynamic_css', 10, 2 );

