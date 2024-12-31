<?php


use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'moovit_contact_forms_layout1' );

/**
 * Contact forms
 */

function moovit_contact_forms_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Contact Form 16', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	aheto_demos_add_dependency( 'bg_color_fields', [ 'moovit_layout1'], $shortcode );

	$shortcode->add_dependecy('moovit_border_error_color', 'template', 'moovit_layout1');

	$shortcode->add_params([
	
		'moovit_border_error_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Border error color', 'moovit'),
			'selectors' => ['{{WRAPPER}} div.wpcf7-validation-errors' => 'border-color: {{VALUE}}'],
		]

	]);

}

function moovit_contact_forms_layout1_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['moovit_border_error_color']) && !empty($shortcode->atts['moovit_border_error_color'])) {
		$css['global']['%1$s div.wpcf7-validation-errors']['border-color'] = \Aheto\Sanitize::color($shortcode->atts['moovit_border_error_color']);
	}
	
	return $css;
	
}
add_filter('aheto_contact_forms_dynamic_css', 'moovit_contact_forms_layout1_dynamic_css', 10, 2);

function moovit_contact_forms_layout1_button( $form_button ) {

	$form_button['dependency'][1][] = 'moovit_layout1';

	return $form_button;

}

add_filter( 'aheto_button_contact-forms', 'moovit_contact_forms_layout1_button', 10, 2 );

