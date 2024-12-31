<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'hryzantema_contents_layout4');

/**
 * Contents Shortcode
 */

function hryzantema_contents_layout4($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'hryzantema_layout4', [
		'title' => esc_html__( 'Content 18', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout4.jpg',
	] );
	$shortcode->add_dependecy( 'hryzantema_text', 'template', ['hryzantema_layout4'] );
	$shortcode->add_dependecy( 'hryzantema_link', 'template', ['hryzantema_layout4'] );
	$shortcode->add_dependecy( 'hryzantema_text_tag', 'template', ['hryzantema_layout4']);
	$shortcode->add_dependecy( 'hryzantema_flex_align', 'template', ['hryzantema_layout4'] );
	$shortcode->add_dependecy( 'hryzantema_use_text_typo', 'template', 'hryzantema_layout4' );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'template', 'hryzantema_layout4' );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'hryzantema_use_text_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_color', 'template', 'hryzantema_layout4' );
	$shortcode->add_dependecy( 'hryzantema_color_hover', 'template', 'hryzantema_layout4' );
	$shortcode->add_params([
		'hryzantema_text_tag'        => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for text', 'hryzantema' ),
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
			'default' => 'p',
			'grid'    => 5,
		],
		'hryzantema_text'             => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Text', 'hryzantema' ),
			'description' => esc_html__( 'Add some text', 'hryzantema' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text', 'hryzantema' ),
		],
		'hryzantema_link'             => [
			'type'        => 'text',
			'heading'     => esc_html__( 'Link Url', 'hryzantema' ),
			'admin_label' => true,
		],
		'hryzantema_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for text?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__text, {{WRAPPER}} .aheto-content-block__title',
		],
		'hryzantema_flex_align'      => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align text', 'hryzantema' ),
			'options' => [
				'center'  => 'center',
				'left'  => 'flex-start',
				'right'  => 'flex-end',
			],
			'default' => 'center',
			'grid'    => 5,
		],
		'hryzantema_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Link color', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-content-block__title a' => 'color: {{VALUE}}'
			],
		],
		'hryzantema_color_hover'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Link color hover', 'hryzantema' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-content-block__title a:hover' => 'color: {{VALUE}}'
			],
		]
	]);
	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon' => true,
		'add_label'  => esc_html__( 'Add icon?', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'exclude'  => ['align'],
		'dependency' => ['template', ['hryzantema_layout4']],
		'group'      => esc_html__( 'Hryzantema Icon', 'hryzantema' ),
	]);
}
function hryzantema_contents_layout4_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_text_typo'] ) && $shortcode->atts['hryzantema_use_text_typo'] && isset( $shortcode->atts['hryzantema_text_typo'] )  && ! empty( $shortcode->atts['hryzantema_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-contents__text'], $shortcode->parse_typography( $shortcode->atts['hryzantema_text_typo'] ) );
	}

	if ( isset( $shortcode->atts['hryzantema_color']) && ! empty( $shortcode->atts['hryzantema_color'] ) ) {
		$color                                                              = Sanitize::color( $shortcode->atts['hryzantema_color'] );
		$css['global']['%1$s .aheto-content-block__title a']['color'] = $color;
	}

	if ( isset( $shortcode->atts['hryzantema_color_hover']) && ! empty( $shortcode->atts['hryzantema_color_hover'] ) ) {
		$color                                                              = Sanitize::color( $shortcode->atts['hryzantema_color_hover'] );
		$css['global']['%1$s .aheto-content-block__title a:hover']['color'] = $color;
	}


	return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'hryzantema_contents_layout4_dynamic_css', 10, 2 );