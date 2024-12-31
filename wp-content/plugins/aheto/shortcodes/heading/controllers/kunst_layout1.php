<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_heading_register', 'kunst_heading_layout1' );

/**
 * Kunst Heading
 */

function kunst_heading_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

    $shortcode->add_layout( 'kunst_layout1', [
        'title' => esc_html__( 'Kunst Simple', 'kunst' ),
        'image' => $preview_dir . 'kunst_layout1.jpg',
    ]);

	aheto_demos_add_dependency( [ 'source', 'text_tag', 'text_typo', 'use_typo' ], [ 'kunst_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'kunst_light_style', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_heading', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_subtitle', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_subtitle_tag', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_align', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_align_tablet', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_align_mobile', 'template', [ 'kunst_layout1' ] );

	$shortcode->add_dependecy( 'kunst_use_subtitle_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_subtitle_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_subtitle_typo', 'kunst_use_subtitle_typo', 'true' );

    $shortcode->add_params([

		'kunst_style'     => [
            'type'    => 'select',
            'heading' => esc_html__( 'Heading Style', 'kunst' ),
            'options' => [
                ''          => esc_html__( 'Dark', 'kunst' ),
                'lightness' => esc_html__( 'Light', 'kunst' ),
            ],
            'default' => ''
		],
		'kunst_subtitle'     => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Subtitle', 'kunst' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Subtitle with text.', 'kunst' ),
        ],
        'kunst_heading'      => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Heading', 'kunst' ),
            'admin_label' => false,
            'default'     => esc_html__( 'Heading with text.', 'kunst' ),
        ],
        'kunst_subtitle_tag' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Element tag for Subtitle', 'kunst' ),
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
            'default' => 'h5'
        ],
        'kunst_align' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align', 'kunst' ),
            'options' => \Aheto\Helper::choices_alignment(),
        ],
        'kunst_align_tablet' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for tablet', 'kunst' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
        ],
        'kunst_align_mobile' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for mobile', 'kunst' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
		],

		'kunst_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_subtitle_typo'        => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],

    ]);
}

function kunst_heading_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_subtitle_typo']) && !empty($shortcode->atts['kunst_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['kunst_subtitle_typo']));
	}

	return $css;

}

add_filter( 'aheto_heading_dynamic_css', 'kunst_heading_layout1_dynamic_css', 10, 2 );
