<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_heading_register', 'mooseoom_heading_layout1' );


/**
 * Heading
 */
function mooseoom_heading_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Heading 13', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout1.jpg',
	] );

	$shortcode->add_dependecy('mooseoom_subtitle', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_subtitle_tag', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_use_subtitle_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_subtitle_typo', 'template', 'mooseoom_layout1');
	$shortcode->add_dependecy('mooseoom_subtitle_typo', 'mooseoom_use_subtitle_typo', 'true');

	aheto_demos_add_dependency(['heading', 'alignment', 'source', 'text_tag', 'use_typo', 'text_typo', 'align_tablet', 'align_mobile'], [ 'mooseoom_layout1' ], $shortcode );

	$shortcode->add_params( [
		'mooseoom_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__('Subtitle', 'mooseoom'),
			'description' => esc_html__('Add some text for Subtitle', 'mooseoom'),
			'admin_label' => true,
			'default'     => esc_html__('Add some text for Subtitle', 'mooseoom'),
		],
		'mooseoom_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Subtitle', 'mooseoom'),
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
		'mooseoom_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'mooseoom'),
			'grid'    => 3,
		],

		'mooseoom_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
	] );

}

function mooseoom_heading_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['mooseoom_use_subtitle_typo']) && !empty($shortcode->atts['mooseoom_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['mooseoom_subtitle_typo']));
	}

	return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'mooseoom_heading_layout1_dynamic_css', 10, 2 );

