<?php


use Aheto\Helper;

add_action ( 'aheto_before_aheto_contact-forms_register', 'ninedok_contact_forms_layout1' );

/**
 * Contact forms
 */

function ninedok_contact_forms_layout1 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Contact Form 18', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );

	$shortcode -> add_dependecy ( 'ninedok_title_tag', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_count_input', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_select_holder_color', 'template', 'ninedok_layout1' );

	aheto_demos_add_dependency ( ['title', 'use_title_typo', 'title_typo', 'border_radius_input', 'border_radius_button', 'bg_color_fields', 'full_width_button'], [ 'ninedok_layout1' ], $shortcode );

	$shortcode -> add_params ( [

		'ninedok_title_tag' => [
			'type' => 'select',
			'heading' => esc_html__ ( 'Element tag for Title', 'ninedok' ),
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
			'default' => 'h5',
			'grid' => 5,
		],
		'ninedok_count_input' => [
			'type' => 'select',
			'heading' => esc_html__ ( 'Max inputs per row', 'ninedok' ),
			'options' => [
				'four' => esc_html__ ( 'Four', 'ninedok' ),
				'three' => esc_html__ ( 'Three', 'ninedok' ),
				'two' => esc_html__ ( 'Two', 'ninedok' ),
			],
			'grid' => 6,
		],
        'ninedok_select_holder_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Select holder color', 'ninedok' ),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .widget_aheto__form .wpcf7 select' => 'color: {{VALUE}}',
            ],
        ],

	] );

}

function ninedok_contact_forms_layout1_button ( $form_button )
{
	$form_button['dependency'][1][] = 'ninedok_layout1';

	return $form_button;
}

add_filter ( 'aheto_button_contact-forms', 'ninedok_contact_forms_layout1_button', 10, 2 );



function ninedok_contact_forms_layout1_dynamic_css($css, $shortcode) {

    if ( isset( $shortcode->atts['ninedok_select_holder_color'] ) && !empty( $shortcode->atts['ninedok_select_holder_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['ninedok_select_holder_color'] );
        $css['global']['%1$s .widget_aheto__form .wpcf7 select']['color'] = $color;
    }

    return $css;
}

add_filter('aheto_contact_forms_dynamic_css', 'ninedok_contact_forms_layout1_dynamic_css', 10, 2);