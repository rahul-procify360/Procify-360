<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'outsourceo_contact_forms_layout1' );

/**
 * Contact forms
 */

function outsourceo_contact_forms_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Contact Form 22', 'outsourceo' ),
		'image' => $preview_dir . 'outsourceo_layout1.jpg',
	] );


	$shortcode->add_dependecy( 'outsourceo_use_validtip_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_validtip_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_validtip_typo', 'outsourceo_use_validtip_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_use_errors_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_errors_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_errors_typo', 'outsourceo_use_errors_typo', 'true' );


	$shortcode->add_params([

		'outsourceo_use_validtip_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for valid-tip?', 'outsourceo' ),
			'grid'    => 3,
		],

		'outsourceo_validtip_typo' => [
			'type'     => 'typography',
			'group'    => 'Valid-tip Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} span .wpcf7-not-valid-tip',
		],
		'outsourceo_use_errors_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for notices?', 'outsourceo' ),
			'grid'    => 3,
		],

		'outsourceo_errors_typo' => [
			'type'     => 'typography',
			'group'    => 'Notices Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.wpcf7-validation-errors, {{WRAPPER}} div.wpcf7-acceptance-missing, {{WRAPPER}} div.wpcf7-response-output',
		],
	]);
}

function outsourceo_contact_forms_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_validtip_typo'] ) && ! empty( $shortcode->atts['outsourceo_validtip_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s span .wpcf7-not-valid-tip'], $shortcode->parse_typography( $shortcode->atts['outsourceo_validtip_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['outsourceo_use_errors_typo'] ) && ! empty( $shortcode->atts['outsourceo_errors_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s div.wpcf7-validation-errors, %1$s div.wpcf7-acceptance-missing, %1$s div.wpcf7-response-output'], $shortcode->parse_typography( $shortcode->atts['outsourceo_errors_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'outsourceo_contact_forms_layout1_dynamic_css', 10, 2 );


function outsourceo_contact_forms_layout1_button( $form_button ) {

	$form_button['dependency'][1][] = 'outsourceo_layout1';

	return $form_button;

}

add_filter( 'aheto_button_contact-forms', 'outsourceo_contact_forms_layout1_button', 10, 2 );