<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_heading_register', 'noize_heading_layout1' );

/**
 * Heading Shortcode
 */
function noize_heading_layout1( $shortcode ) {
    $preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'noize_layout1', [
		'title' => esc_html__( 'Heading 16', 'noize' ),
		'image' => $preview_dir . 'noize_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'noize_heading', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_subtitle', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_subtitle_tag', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_align', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_align_tablet', 'template', [ 'noize_layout1' ] );
    $shortcode->add_dependecy( 'noize_align_mobile', 'template', [ 'noize_layout1' ] );

    $shortcode->add_dependecy( 'noize_use_subtitle_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_subtitle_typo', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_subtitle_typo', 'noize_use_subtitle_typo', 'true' );

    aheto_demos_add_dependency( ['source', 'text_tag', 'use_typo', 'text_typo', 'image'], [ 'noize_layout1'], $shortcode );

    $shortcode->depedency['text_logo']['use_typo'][] = 'noize_layout1';

	$shortcode->add_params( [
        'noize_heading'      => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Heading', 'noize' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Heading with text.', 'noize' ),
        ],
        'noize_subtitle'     => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Subtitle', 'noize' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Subtitle with text.', 'noize' ),
		],
        'noize_subtitle_tag' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Element tag for Subtitle', 'noize' ),
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
		'noize_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'noize'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
        'noize_align_tablet' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for tablet', 'noize' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
        ],
        'noize_align_mobile' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for mobile', 'noize' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
        ],
        'noize_use_subtitle_typo' => [
            'type' => 'switch',
            'heading' => esc_html__ ( 'Use custom font for Subtitle?', 'noize' ),
            'grid' => 3,
        ],
        'noize_subtitle_typo' => [
            'type' => 'typography',
            'group' => 'Subtitle Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
        ],
	] );
}

function noize_heading_layout1_dynamic_css ( $css, $shortcode ) {
	if ( !empty( $shortcode -> atts['noize_use_subtitle_typo'] ) && !empty( $shortcode -> atts['noize_subtitle_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode -> parse_typography ( $shortcode -> atts['noize_subtitle_typo'] ) );
	}

	return $css;
}

add_filter ( 'aheto_heading_dynamic_css', 'noize_heading_layout1_dynamic_css', 10, 2 );