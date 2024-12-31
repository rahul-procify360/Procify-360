<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'hryzantema_contents_layout3');

/**
 * Contents Shortcode
 */

function hryzantema_contents_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'hryzantema_layout3', [
		'title' => esc_html__( 'Content 17', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'hryzantema_video_image', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_video_image', 'hryzantema_add_video_button', 'true' );

	$shortcode->add_dependecy( 'hryzantema_title', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_title_tag', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_text', 'template', ['hryzantema_layout3'] );
	$shortcode->add_dependecy( 'hryzantema_text_tag', 'template', ['hryzantema_layout3']);
	$shortcode->add_dependecy( 'hryzantema_background', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_text_color', 'template', 'hryzantema_layout3' );

	$shortcode->add_dependecy( 'hryzantema_background_type', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_bg_image', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_background', 'hryzantema_background_type', 'color' );
	$shortcode->add_dependecy( 'hryzantema_bg_image', 'hryzantema_background_type', 'image' );

	$shortcode->add_dependecy( 'hryzantema_use_text_typo', 'template', ['hryzantema_layout3'] );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_text_typo', 'hryzantema_use_text_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_use_title_typo', 'template', ['hryzantema_layout3'] );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'template', 'hryzantema_layout3' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'hryzantema_use_title_typo', 'true' );
	$shortcode->add_params([
		'hryzantema_title'            => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Title', 'hryzantema' ),
			'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]].', 'hryzantema' ),
			'admin_label' => true,
			'default'     => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'hryzantema' ),
		],
		'hryzantema_title_tag'        => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Title', 'hryzantema' ),
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
			'default' => 'h2',
			'grid'    => 5,
		],
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
		'hryzantema_background_type' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Content background type', 'hryzantema' ),
			'options' => [
				'color' => esc_html__( 'Color', 'hryzantema' ),
				'image' => esc_html__( 'Image', 'hryzantema' ),
			],
			'default' => 'color',
		],
		'hryzantema_background'       => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background for content', 'hryzantema' ),
			'grid'      => 6,
			'default'   => '#131c21',
			'selectors' => [
				'{{WRAPPER}} .aheto-contents__wrapper' => 'background-color: {{VALUE}}',
			],
		],
		'hryzantema_bg_image'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Content background image', 'hryzantema' ),
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
		'hryzantema_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-contents__title',
		],
		'hryzantema_video_image'      => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Preview image for video', 'hryzantema' ),
			'group'   => esc_html__( 'Hryzantema Video Content', 'hryzantema' ),
		],
	]);
	\Aheto\Params::add_video_button_params( $shortcode, [
		'add_label'  => esc_html__( 'Add video?', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'group'      => esc_html__( 'Hryzantema Video Content', 'hryzantema' ),
		'dependency' => [ 'template', 'hryzantema_layout3' ],
	] );
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix'     => 'hryzantema_link_',
		'icons'      => true,
		'dependency' => [ 'template', 'hryzantema_layout3' ],
		'group'      => esc_html__( 'Hryzantema Button', 'hryzantema' ),
	] );
}
function hryzantema_contents_layout3_dynamic_css( $css, $shortcode ) {
	if ( ! empty( $shortcode->atts['hryzantema_background'] ) ) {
		$color                                                              = Sanitize::color( $shortcode->atts['hryzantema_background'] );
		$css['global']['%1$s .aheto-contents__wrapper']['background-color'] = $color;
	}

	if ( ! empty( $shortcode->atts['hryzantema_text_color'] ) ) {
		$color                                                             = Sanitize::color( $shortcode->atts['hryzantema_text_color'] );
		$css['global']['%1$s .aheto-contents__inner_wrapper > *']['color'] = $color;
	}

	if ( isset( $shortcode->atts['hryzantema_use_text_typo'] ) && $shortcode->atts['hryzantema_use_text_typo'] && isset( $shortcode->atts['hryzantema_text_typo'] )  && ! empty( $shortcode->atts['hryzantema_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-contents__text'], $shortcode->parse_typography( $shortcode->atts['hryzantema_text_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_title_typo'] ) && $shortcode->atts['hryzantema_use_title_typo'] && isset( $shortcode->atts['hryzantema_title_typo'] )  && ! empty( $shortcode->atts['hryzantema_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-contents__title'], $shortcode->parse_typography( $shortcode->atts['hryzantema_title_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'hryzantema_contents_layout3_dynamic_css', 10, 2 );
