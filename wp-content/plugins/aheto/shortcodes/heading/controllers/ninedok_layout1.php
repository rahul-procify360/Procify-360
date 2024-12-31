<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_heading_register', 'ninedok_heading_layout1' );


/**
 * Heading
 */
function ninedok_heading_layout1 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Heading 15', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );

	$shortcode -> add_dependecy ( 'ninedok_subtitle', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_subtitle_tag', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_use_subtitle_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_align_mobile', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_description', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_desc_max_width', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'title_animation', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_desk_tag', 'template', 'ninedok_layout1' );

	$shortcode -> add_dependecy ( 'ninedok_use_subtitle_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_subtitle_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_subtitle_typo', 'ninedok_use_subtitle_typo', 'true' );

	$shortcode -> add_dependecy ( 'ninedok_use_description_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_description_typo', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_description_typo', 'ninedok_use_description_typo', 'true' );

	aheto_demos_add_dependency ( ['alignment', 'heading', 'text_tag', 'use_typo', 'text_typo'], [ 'ninedok_layout1' ], $shortcode );

	$shortcode -> add_params ( [
		'ninedok_subtitle' => [
			'type' => 'textarea',
			'heading' => esc_html__ ( 'Subtitle', 'ninedok' ),
			'description' => esc_html__ ( 'Add some text for Subtitle', 'ninedok' ),
			'admin_label' => true,
			'default' => esc_html__ ( 'Add some text for Subtitle', 'ninedok' ),
		],
		'ninedok_desk_tag' => [
			'type' => 'select',
			'heading' => esc_html__ ( 'Element tag for Description', 'ninedok' ),
			'options' => [
				'h1' => 'h1',
				'h2' => 'h2',
				'h3' => 'h3',
				'h4' => 'h4',
				'h5' => 'h5',
				'h6' => 'h6',
				'p' => 'p',
				'div' => 'div',
			],
			'default' => 'p',
			'grid' => 5,
		],
		'ninedok_use_subtitle_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Subtitle?', 'ninedok' ),
			'grid' => 3,
		],
		'ninedok_subtitle_typo' => [
			'type' => 'typography',
			'group' => 'Subtitle Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'ninedok_use_description_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Description?', 'ninedok' ),
			'grid' => 3,
		],
		'ninedok_description_typo' => [
			'type' => 'typography',
			'group' => 'Description Typography',
			'settings' => [
				'tag' => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__description',
		],
		'ninedok_description' => [
			'type' => 'textarea',
			'heading' => esc_html__ ( 'Description', 'ninedok' ),
			'description' => esc_html__ ( 'Add some text for Description', 'ninedok' ),
			'admin_label' => true,
			'default' => esc_html__ ( 'Add some text for Description', 'ninedok' ),
		],
		'ninedok_desc_max_width' => [
			'type' => 'slider',
			'heading' => esc_html__ ( 'Description Max width', 'ninedok' ),
			'group' => esc_html__ ( 'Content', 'ninedok' ),
			'grid' => 6,
			'range' => [
				'px' => [
					'min' => 10,
					'max' => 1920,
					'step' => 5,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-heading__description' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
			],
		],
	] );

}

function ninedok_heading_layout1_dynamic_css ( $css, $shortcode )
{

	if ( !empty( $shortcode -> atts['ninedok_use_subtitle_typo'] ) && !empty( $shortcode -> atts['ninedok_subtitle_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode -> parse_typography ( $shortcode -> atts['ninedok_subtitle_typo'] ) );
	}
	if ( !empty( $shortcode -> atts['ninedok_use_description_typo'] ) && !empty( $shortcode -> atts['ninedok_description_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-heading__description'], $shortcode -> parse_typography ( $shortcode -> atts['ninedok_description_typo'] ) );
	}
	if ( !empty( $shortcode -> atts['ninedok_desc_max_width'] )) {
		$css['global']['%1$s .aheto-heading__description']['max-width'] = Sanitize ::size ( $shortcode -> atts['ninedok_desc_max_width'] );
		$css['global']['%1$s .aheto-heading__description']['margin-left'] = 'auto';
		$css['global']['%1$s .aheto-heading__description']['margin-right'] = 'auto';
	}

	return $css;
}

add_filter ( 'aheto_heading_dynamic_css', 'ninedok_heading_layout1_dynamic_css', 10, 2 );

