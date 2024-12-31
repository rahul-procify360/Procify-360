<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'noize_contact_forms_layout1' );

/**
 * Contact forms Shortcode
 */
function noize_contact_forms_layout1( $shortcode ) {
	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'noize_layout1', [
		'title' => esc_html__( 'Noize Subscribe', 'noize' ),
		'image' => $preview_dir . 'noize_layout1.jpg',
	] );

	aheto_demos_add_dependency( 'bg_color_fields', [ 'noize_layout1' ], $shortcode );


	$shortcode->add_dependecy( 'noize_color_text', 'template', 'noize_layout1' );
	$shortcode->add_dependecy( 'noize_color_placeholder', 'template', 'noize_layout1' );
	$shortcode->add_dependecy( 'noize_text_cursor_color', 'template', 'noize_layout1' );

	$shortcode->add_params([

		'noize_color_text'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Text input color', 'noize'),
			'selectors' => ['{{WRAPPER}} input:-webkit-autofill,
			 {{WRAPPER}} input:-webkit-autofill:focus,
			  {{WRAPPER}} .wpcf7 input:not([type=submit]),
			  {{WRAPPER}} .wpcf7 textarea' => '-webkit-text-fill-color: {{VALUE}};'],
		],
		'noize_color_placeholder'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Placeholder color', 'noize'),
			'selectors' => ['{{WRAPPER}} .wpcf7 textarea::placeholder,
			{{WRAPPER}} .wpcf7 input:not([type=submit])::placeholder' => 'color: {{VALUE}}; -webkit-text-fill-color: {{VALUE}};'],
		],
			'noize_text_cursor_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Text cursor color', 'noize'),
			'selectors' => ['
			{{WRAPPER}} .wpcf7 input:not([type=submit])' => 'color: {{VALUE}};'],
		]
	]);
}

function noize_contact_forms_layout1_button( $form_button ) {
	$form_button['dependency'][1][] = 'noize_layout1';

	return $form_button;
}

add_filter( 'aheto_button_contact-forms', 'noize_contact_forms_layout1_button', 10, 2 );



function noize_contact_forms_layout2_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['noize_color_text']) && !empty($shortcode->atts['noize_color_text'])) {
		$css['global']['%1$s input:-webkit-autofill, %1$s input:-webkit-autofill:focus, %1$s .wpcf7 input:not([type=submit]), %1$s .wpcf7 textarea']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['noize_color_text']);
	}

	if (isset($shortcode->atts['noize_color_placeholder']) && !empty($shortcode->atts['noize_color_placeholder'])) {
		$css['global']['%1$s .wpcf7 textarea::placeholder, %1$s .wpcf7 input:not([type=submit])::placeholder']['color'] = \Aheto\Sanitize::color($shortcode->atts['noize_color_placeholder']);
		$css['global']['%1$s .wpcf7 textarea::placeholder, %1$s .wpcf7 input:not([type=submit])::placeholder']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['noize_color_placeholder']);
	}
		if (isset($shortcode->atts['noize_text_cursor_color']) && !empty($shortcode->atts['noize_text_cursor_color'])) {
		$css['global']['%1$s .wpcf7 input:not([type=submit])']['color'] = \Aheto\Sanitize::color($shortcode->atts['noize_text_cursor_color']);
	}

	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'noize_contact_forms_layout2_dynamic_css', 10, 2 );
