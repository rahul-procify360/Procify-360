<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_contact-forms_register', 'bizy_contact_forms_layout1' );

/**
 * Contact forms
 */

function bizy_contact_forms_layout1 ( $shortcode ){

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode -> add_layout ( 'bizy_layout1', [
		'title' => esc_html__ ( 'Contact Form 19', 'bizy' ),
		'image' => $preview_dir . 'bizy_layout1.jpg',
	] );

	aheto_demos_add_dependency ( ['border_radius_input', 'border_radius_button', 'bg_color_fields'], [ 'bizy_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'bizy_color_text', 'template', 'bizy_layout1' );
	$shortcode->add_dependecy( 'bizy_color_placeholder', 'template', 'bizy_layout1' );

	$shortcode->add_params([

		'bizy_color_text'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Text input color', 'bizy'),
			'selectors' => ['{{WRAPPER}} input:-webkit-autofill,
			 {{WRAPPER}} input:-webkit-autofill:focus,
			  {{WRAPPER}} .widget_aheto__form .wpcf7 input:not([type=submit]),
			  {{WRAPPER}} .widget_aheto__form .wpcf7 textarea' => '-webkit-text-fill-color: {{VALUE}};'],
		],
		'bizy_color_placeholder'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Placeholder color', 'bizy'),
			'selectors' => ['{{WRAPPER}} .widget_aheto__form .wpcf7 textarea::placeholder,
			{{WRAPPER}} .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder' => 'color: {{VALUE}}; -webkit-text-fill-color: {{VALUE}};'],
		]
	]);
}


function bizy_contact_forms_layout1_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['bizy_color_text']) && !empty($shortcode->atts['bizy_color_text'])) {
		$css['global']['%1$s input:-webkit-autofill, %1$s input:-webkit-autofill:focus, %1$s .widget_aheto__form .wpcf7 input:not([type=submit]), %1$s .widget_aheto__form .wpcf7 textarea']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['bizy_color_text']);
	}

	if (isset($shortcode->atts['bizy_color_placeholder']) && !empty($shortcode->atts['bizy_color_placeholder'])) {
		$css['global']['%1$s .widget_aheto__form .wpcf7 textarea::placeholder, %1$s .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder']['color'] = \Aheto\Sanitize::color($shortcode->atts['bizy_color_placeholder']);
		$css['global']['%1$s .widget_aheto__form .wpcf7 textarea::placeholder, %1$s .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['bizy_color_placeholder']);
	}

	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'bizy_contact_forms_layout1_dynamic_css', 10, 2 );

function bizy_contact_forms_layout1_button ( $form_button ){

	$form_button['dependency'][1][] = 'bizy_layout1';

	return $form_button;

}

add_filter ( 'aheto_button_contact-forms', 'bizy_contact_forms_layout1_button', 10, 2 );