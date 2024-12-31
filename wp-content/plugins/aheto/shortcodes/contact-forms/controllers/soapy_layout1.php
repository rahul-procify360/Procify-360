<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'soapy_contact_forms_layout1');

/**
 * Contact forms Shortcode
 */

function soapy_contact_forms_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Contact Form 27', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	$shortcode->add_dependecy( 'soapy_color_text', 'template', 'soapy_layout1');
	$shortcode->add_dependecy( 'soapy_color_placeholder', 'template', 'soapy_layout1');
	$shortcode->add_dependecy( 'soapy_color_error', 'template', 'soapy_layout1');
	$shortcode->add_dependecy( 'soapy_color_success', 'template', 'soapy_layout1');


	aheto_demos_add_dependency(['bg_color_fields', 'count_input', 'button_align', 'full_width_button'], ['soapy_layout1'], $shortcode);

	$shortcode->add_params([
	
		'soapy_color_text'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Text input color', 'soapy'),
			'selectors' => ['{{WRAPPER}} input:-webkit-autofill,
			 {{WRAPPER}} input:-webkit-autofill:focus,
			  {{WRAPPER}} .widget_aheto__form .wpcf7 input:not([type=submit]),
			  {{WRAPPER}} .widget_aheto__form .wpcf7 textarea' => '-webkit-text-fill-color: {{VALUE}};'],
		],
		'soapy_color_placeholder'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Placeholder color', 'soapy'),
			'selectors' => ['{{WRAPPER}} .widget_aheto__form .wpcf7 textarea::placeholder,
			{{WRAPPER}} .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder' => 'color: {{VALUE}}; -webkit-text-fill-color: {{VALUE}};'],
		],
		'soapy_color_error'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Error color', 'soapy'),
			'selectors' => ['{{WRAPPER}} .wpcf7-not-valid-tip,
			{{WRAPPER}} .wpcf7 form.invalid .wpcf7-response-output' => 'color:  {{VALUE}};'],
		],
		'soapy_color_success'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Success color', 'soapy'),
			'selectors' => ['{{WRAPPER}} .wpcf7 form.sent .wpcf7-response-output' => 'color:  {{VALUE}};'],
		],
		

	]);

}

function soapy_contact_forms_layout1_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['soapy_color_text']) && !empty($shortcode->atts['soapy_color_text'])) {
		$css['global']['%1$s input:-webkit-autofill, %1$s input:-webkit-autofill:focus, %1$s .widget_aheto__form .wpcf7 input:not([type=submit]), %1$s .widget_aheto__form .wpcf7 textarea']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['soapy_color_text']);
	}
	
	if (isset($shortcode->atts['soapy_color_placeholder']) && !empty($shortcode->atts['soapy_color_placeholder'])) {
		$css['global']['%1$s .widget_aheto__form .wpcf7 textarea::placeholder, %1$s .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder']['color'] = \Aheto\Sanitize::color($shortcode->atts['soapy_color_placeholder']);
		$css['global']['%1$s .widget_aheto__form .wpcf7 textarea::placeholder, %1$s .widget_aheto__form .wpcf7 input:not([type=submit])::placeholder']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['soapy_color_placeholder']);
	}

	if (isset($shortcode->atts['soapy_color_error']) && !empty($shortcode->atts['soapy_color_error'])) {
		$css['global']['%1$s .wpcf7-not-valid-tip']['color'] = \Aheto\Sanitize::color($shortcode->atts['soapy_color_error']);
		$css['global']['%1$s .wpcf7 form.invalid .wpcf7-response-output']['color'] = \Aheto\Sanitize::color($shortcode->atts['soapy_color_error']);
	}
	if (isset($shortcode->atts['soapy_color_success']) && !empty($shortcode->atts['soapy_color_success'])) {
		$css['global']['%1$s .wpcf7 form.sent .wpcf7-response-output']['color'] = \Aheto\Sanitize::color($shortcode->atts['soapy_color_success']);
	}

	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'soapy_contact_forms_layout1_dynamic_css', 10, 2 );

function soapy_contact_forms_layout1_button($form_button) {

	$form_button['dependency'][1][] = 'soapy_layout1';

	return $form_button;
}

add_filter('aheto_button_contact-forms', 'soapy_contact_forms_layout1_button', 10, 2);

