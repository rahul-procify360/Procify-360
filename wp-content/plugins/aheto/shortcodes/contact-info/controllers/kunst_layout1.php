<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-info_register', 'kunst_contact_info_layout1' );

/**
* Kunst Contact Info Shortcode
*/

function kunst_contact_info_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-info/previews/';

    $shortcode->add_layout( 'kunst_layout1', [
        'title' => esc_html__( 'Kunst Contact Info Simple', 'kunst' ),
        'image' => $preview_dir . 'kunst_layout1.jpg',
	]);

	aheto_demos_add_dependency( [ 'text_typo', 'use_typo_text' ], [ 'kunst_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'kunst_image', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_title', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_address', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_phone', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_email', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_align', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_align_tablet', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_align_mobile', 'template', 'kunst_layout1' );

	$shortcode->add_dependecy( 'kunst_use_typo_title', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_text_typo_title', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_text_typo_title', 'kunst_use_typo_title', 'true' );

    $shortcode->add_params( [

		'kunst_image'     => [
			'type'    => 'attach_image',
			'heading' => esc_html__( 'Additional Image', 'kunst' ),
		],
		'kunst_title'     => [
            'type'    => 'text',
            'heading' => esc_html__( 'Title', 'kunst' ),
        ],
        'kunst_address'     => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Address', 'kunst' ),
        ],
        'kunst_phone'       => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Phone', 'kunst' ),
        ],
        'kunst_email'       => [
            'type'    => 'text',
            'heading' => esc_html__( 'Email', 'kunst' ),
		],
		'kunst_align' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align Content', 'kunst' ),
            'options' => \Aheto\Helper::choices_alignment(),
		],
		'kunst_align_tablet' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align Content for tablet', 'kunst' ),
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
            'heading' => esc_html__( 'Align Content for mobile', 'kunst' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
		],

		'kunst_use_typo_title'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Title?', 'kunst' ),
            'grid'    => 6,
        ],
        'kunst_text_typo_title'   => [
            'type'     => 'typography',
            'group'    => 'Title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .widget_kunst__title',
        ],

	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'kunst_',
        'dependency' => [ 'template', [ 'kunst_layout1' ] ]
    ]);

}

function kunst_contact_info_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['kunst_use_typo_title'] ) && ! empty( $shortcode->atts['kunst_text_typo_title'] ) ) {
        \aheto_add_props( $css['global']['%1$s .widget_kunst__title'], $shortcode->parse_typography( $shortcode->atts['kunst_text_typo_title'] ) );
    }

    return $css;

}

add_filter( 'aheto_dynamic_css_contact_info', 'kunst_contact_info_layout1_dynamic_css', 10, 2 );
