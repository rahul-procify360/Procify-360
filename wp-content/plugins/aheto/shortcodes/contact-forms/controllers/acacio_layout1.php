<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'acacio_contact_forms_layout1' );

/**
 *  Banner Slider
 */

function acacio_contact_forms_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/contact-forms/previews/';

    $shortcode->add_layout( 'acacio_layout1', [
        'title' => esc_html__( 'Contact Form 1', 'acacio' ),
        'image' => $preview_dir . 'acacio_layout1.jpg',
    ] );

    aheto_demos_add_dependency( ['title', 'use_title_typo', 'title_typo', 'full_width_button', 'count_input', 'button_align', 'border_radius_button', 'border_radius_input', 'bg_color_fields'], [ 'acacio_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_max_width', 'template', 'acacio_layout1' );

	$shortcode->add_dependecy( 'acacio_use_text_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_text_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_text_typo', 'acacio_use_text_typo', 'true' );


	$shortcode->add_params([
        'acacio_max_width'    => [
            'type'      => 'slider',
            'heading'   => esc_html__('Form Max width', 'acacio'),
            'grid'      => 4,
            'size_units' => [ 'px', '%', 'vh' ],
            'range'     => [
                'px' => [
                    'min'  => 200,
                    'max'  => 2000,
                    'step' => 5,
                ],
                '%' => [
                    'min'  => 0,
                    'max'  => 100,
                ],
                'vh' => [
                    'min'  => 0,
                    'max'  => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .widget_aheto__form' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ],
	    'acacio_use_text_typo' => [
		    'type'    => 'switch',
		    'heading' => esc_html__( 'Use custom font for input text?', 'acacio' ),
		    'grid'    => 3,
	    ],
	    'acacio_text_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Text input Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} form span > input',
	    ],
    ]);
}
function acacio_contact_forms_layout1_dynamic_css($css, $shortcode) {

	if ( isset( $shortcode->atts['acacio_use_text_typo'] ) && ! empty( $shortcode->atts['acacio_use_text_typo'] ) && isset( $shortcode->atts['acacio_text_typo'] ) && ! empty( $shortcode->atts['acacio_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s form span > input'], $shortcode->parse_typography( $shortcode->atts['acacio_text_typo'] ) );
	}

	return $css;
}

add_filter('aheto_contact_forms_dynamic_css', 'acacio_contact_forms_layout1_dynamic_css', 10, 2);

function acacio_contact_forms_layout1_button( $form_button ) {

    $form_button['dependency'][1][] = 'acacio_layout1';

    return $form_button;

}

add_filter( 'aheto_button_contact-forms', 'acacio_contact_forms_layout1_button', 10, 2 );



