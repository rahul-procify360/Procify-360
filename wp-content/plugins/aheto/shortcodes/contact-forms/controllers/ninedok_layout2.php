<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_contact-forms_register', 'ninedok_contact_forms_layout2' );

/**
 * Contact forms
 */

function ninedok_contact_forms_layout2 ( $shortcode ){

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode -> add_layout ( 'ninedok_layout2', [
		'title' => esc_html__ ( 'Contact Form 19', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout2.jpg',
	] );

	aheto_demos_add_dependency ( ['border_radius_input', 'border_radius_button', 'bg_color_fields'], [ 'ninedok_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'ninedok_color_text', 'template', 'ninedok_layout2' );
	$shortcode->add_dependecy( 'ninedok_color_placeholder', 'template', 'ninedok_layout2' );

	$shortcode->add_params([

		'ninedok_color_text'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Text input color', 'ninedok'),
			'selectors' => ['{{WRAPPER}} input:-webkit-autofill,
			 {{WRAPPER}} input:-webkit-autofill:focus,
			  {{WRAPPER}} .widget_aheto__form .wpcf7 input:not([type=submit]),
			  {{WRAPPER}} .widget_aheto__form .wpcf7 textarea' => '-webkit-text-fill-color: {{VALUE}};'],
		],
		'ninedok_color_placeholder'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Placeholder color', 'ninedok'),
			'selectors' => ['{{WRAPPER}} .widget_aheto__form .wpcf7 textarea::placeholder,
			{{WRAPPER}} .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder' => 'color: {{VALUE}}; -webkit-text-fill-color: {{VALUE}};'],
		]
	]);
}


function ninedok_contact_forms_layout2_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['ninedok_color_text']) && !empty($shortcode->atts['ninedok_color_text'])) {
		$css['global']['%1$s input:-webkit-autofill, %1$s input:-webkit-autofill:focus, %1$s .widget_aheto__form .wpcf7 input:not([type=submit]), %1$s .widget_aheto__form .wpcf7 textarea']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['ninedok_color_text']);
	}

	if (isset($shortcode->atts['ninedok_color_placeholder']) && !empty($shortcode->atts['ninedok_color_placeholder'])) {
		$css['global']['%1$s .widget_aheto__form .wpcf7 textarea::placeholder, %1$s .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder']['color'] = \Aheto\Sanitize::color($shortcode->atts['ninedok_color_placeholder']);
		$css['global']['%1$s .widget_aheto__form .wpcf7 textarea::placeholder, %1$s .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['ninedok_color_placeholder']);
	}

	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'ninedok_contact_forms_layout2_dynamic_css', 10, 2 );

function ninedok_contact_forms_layout2_button ( $form_button ){

	$form_button['dependency'][1][] = 'ninedok_layout2';

	return $form_button;

}

add_filter ( 'aheto_button_contact-forms', 'ninedok_contact_forms_layout2_button', 10, 2 );