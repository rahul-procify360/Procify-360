<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'hryzantema_heading_layout1');

/**
 * Heading Shortcode
 */

function hryzantema_heading_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Heading 8', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'hryzantema_align_mobile', 'template', ['hryzantema_layout1'] );
	// HR Consult simple with highlighted text
	$shortcode->add_dependecy( 'hryzantema_subtitle', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_subtitle_tag', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_use_subtitle_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_use_dot', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_subtitle_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_subtitle_typo', 'hryzantema_use_subtitle_typo', 'true' );
	aheto_demos_add_dependency(['heading','alignment', 'text_tag', 'source', 'use_typo', 'text_typo', 'use_typo_hightlight', 'text_typo_hightlight', 'title_animation'], ['hryzantema_layout1'], $shortcode);

	$shortcode->add_params( [
		'hryzantema_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Subtitle', 'hryzantema' ),
			'description' => esc_html__( 'Add some text for Subtitle', 'hryzantema' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for Subtitle', 'hryzantema' ),
		],
		'hryzantema_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Subtitle', 'hryzantema' ),
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
		'hryzantema_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Subtitle?', 'hryzantema' ),
			'grid'    => 3,
		],
		'hryzantema_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'hryzantema_use_dot'          => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot in the end title?', 'hryzantema' ),
			'grid'    => 12,
		],
		'hryzantema_align_mobile' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align for mobile', 'hryzantema' ),
			'options' => [
				'default' => 'Default',
				'left'    => 'Left',
				'center'  => 'Center',
				'right'   => 'Right',
			],
			'default' => 'default',
		],
	]);
}
function hryzantema_heading_layout1_dynamic_css($css, $shortcode) {
	if ( isset( $shortcode->atts['hryzantema_use_subtitle_typo'] ) && $shortcode->atts['hryzantema_use_subtitle_typo']  && isset( $shortcode->atts['hryzantema_subtitle_typo'] ) && ! empty( $shortcode->atts['hryzantema_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography( $shortcode->atts['hryzantema_subtitle_typo'] ) );
	}
	return $css;
}

add_filter('aheto_heading_dynamic_css', 'hryzantema_heading_layout1_dynamic_css', 10, 2);

