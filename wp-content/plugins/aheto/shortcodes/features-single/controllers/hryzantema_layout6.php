<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'hryzantema_features_single_layout6');

/**
 * Features Single Shortcode
 */

function hryzantema_features_single_layout6($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout( 'hryzantema_layout6', [
		'title' => esc_html__( 'Features Single 24', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout6.jpg',
	] );
	$shortcode->add_dependecy( 'hr_features_modern_vertical', 'template', 'hryzantema_layout6' );
	$shortcode->add_dependecy( 'hryzantema_use_title_typo', 'template', 'hryzantema_layout6' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'template', 'hryzantema_layout6' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'hryzantema_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_description_typo', 'template', 'hryzantema_layout6' );
	$shortcode->add_dependecy( 'hryzantema_description_typo', 'template', 'hryzantema_layout6' );
	$shortcode->add_dependecy( 'hryzantema_description_typo', 'hryzantema_use_description_typo', 'true' );

	$shortcode->add_params( [
		'hr_features_modern_vertical' => [
			'type'    => 'group',
			'heading' => esc_html__( 'HR Consult Features Modern (Vertical)', 'hryzantema' ),
			'params'  => [
				'hryzantema_features_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Image', 'hryzantema' ),
				],
				'hryzantema_features_counter_bg'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Add your background image for numbers', 'hryzantema' ),
				],
				'hryzantema_features_title_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Add your title image ', 'hryzantema' ),
				],
				'hryzantema_features_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title', 'hryzantema' ),
					'description' => esc_html__( 'Set your title', 'hryzantema' ),
					'admin_label' => true,
					'default'     => esc_html__( 'Title', 'hryzantema' ),
				],
				'hryzantema_features_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'hryzantema' ),
				],
			]
		],
		'hryzantema_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'hryzantema' ),
			'grid'    => 2,
		],

		'hryzantema_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-block__title, {{WRAPPER}} .aheto-features-block__title h5',
		],
		'hryzantema_use_description_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_description_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-block__info-text',
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for images ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', ['hryzantema_layout6'] ]
	]);
}

function hryzantema_features_single_layout6_dynamic_css( $css, $shortcode ) {
	if ( isset( $shortcode->atts['hryzantema_use_title_typo'] ) && $shortcode->atts['hryzantema_use_title_typo'] && isset( $shortcode->atts['hryzantema_title_typo'] ) && ! empty( $shortcode->atts['hryzantema_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-block__title'], $shortcode->parse_typography( $shortcode->atts['hryzantema_title_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_description_typo'] ) && $shortcode->atts['hryzantema_use_description_typo'] && isset( $shortcode->atts['hryzantema_description_typo'] ) && ! empty( $shortcode->atts['hryzantema_description_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-features-block__info-text'], $shortcode->parse_typography( $shortcode->atts['hryzantema_description_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_features_single_dynamic_css', 'hryzantema_features_single_layout6_dynamic_css', 10, 2 );

