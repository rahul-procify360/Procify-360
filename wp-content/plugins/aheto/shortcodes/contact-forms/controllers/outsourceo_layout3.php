<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'outsourceo_contact_forms_layout3' );

/**
 * Contact forms
 */

function outsourceo_contact_forms_layout3( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'outsourceo_layout3', [
		'title' => esc_html__( 'Contact Form 24', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout3.jpg',
	] );


	aheto_demos_add_dependency( ['title', 'use_title_typo', 'title_typo', 'count_input', 'button_align', 'border_radius_button', 'border_radius_input', 'bg_color_fields', 'full_width_button'], [ 'outsourceo_layout3' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_title_tag', 'template', 'outsourceo_layout3' );
	$shortcode->add_dependecy( 'outsourceo_full_width_input', 'template', 'outsourceo_layout3' );
    $shortcode->add_dependecy ( 'outsourceo_select_holder_color', 'template', 'outsourceo_layout3' );



    $shortcode->add_params( [

		'outsourceo_title_tag'        => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Title', 'outsourceo' ),
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
		'outsourceo_full_width_input' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Full width input', 'outsourceo' ),
			'grid'    => 12,
		],
        'outsourceo_select_holder_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Select holder color', 'outsourceo' ),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .widget_aheto__form .wpcf7 select' => 'color: {{VALUE}}',
            ],
        ],
	] );

}

function outsourceo_contact_forms_layout3_button( $form_button ) {

	$form_button['dependency'][1][] = 'outsourceo_layout3';

	return $form_button;

}

add_filter( 'aheto_button_contact-forms', 'outsourceo_contact_forms_layout3_button', 10, 2 );


function outsourceo_contact_forms_layout3_dynamic_css($css, $shortcode) {

    if ( isset( $shortcode->atts['outsourceo_select_holder_color'] ) && !empty( $shortcode->atts['outsourceo_select_holder_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['outsourceo_select_holder_color'] );
        $css['global']['%1$s .widget_aheto__form .wpcf7 select']['color'] = $color;
    }

    return $css;
}

add_filter('aheto_contact_forms_dynamic_css', 'outsourceo_contact_forms_layout3_dynamic_css', 10, 2);