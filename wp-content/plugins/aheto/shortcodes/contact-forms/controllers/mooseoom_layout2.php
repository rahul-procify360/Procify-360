<?php


use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'mooseoom_contact_forms_layout2' );

/**
 * Contact forms
 */

function mooseoom_contact_forms_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'mooseoom_layout2', [
		'title' => esc_html__( 'Contact Form 14', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'mooseoom_use_text_typo', 'template', 'mooseoom_layout2' );
	$shortcode->add_dependecy( 'mooseoom_text_typo', 'template', 'mooseoom_layout2' );
	$shortcode->add_dependecy( 'mooseoom_text_typo', 'mooseoom_use_text_typo', 'true' );
	
	$shortcode->add_dependecy( 'mooseoom_use_submit_typo', 'template', 'mooseoom_layout2' );
	$shortcode->add_dependecy( 'mooseoom_submit_typo', 'template', 'mooseoom_layout2' );
	$shortcode->add_dependecy( 'mooseoom_submit_typo', 'mooseoom_use_submit_typo', 'true' );

	$shortcode->add_params([
		
		'mooseoom_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Text?', 'mooseoom' ),
			'grid'    => 3,
		],

		'mooseoom_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__form .wpcf7 input, {{WRAPPER}} .widget_aheto__form .wpcf7 textarea',
		],
		
		'mooseoom_use_submit_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Submit?', 'mooseoom' ),
			'grid'    => 3,
		],

		'mooseoom_submit_typo' => [
			'type'     => 'typography',
			'group'    => 'Submit Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__form .wpcf7 .wpcf7-submit',
		],

	]);
}
function mooseoom_contact_forms_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['mooseoom_use_text_typo'] ) && ! empty( $shortcode->atts['mooseoom_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .widget_aheto__form .wpcf7 textarea, %1$s .widget_aheto__form .wpcf7 input'], $shortcode->parse_typography( $shortcode->atts['mooseoom_text_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['mooseoom_use_submit_typo'] ) && ! empty( $shortcode->atts['mooseoom_submit_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .widget_aheto__form .wpcf7 .wpcf7-submit'], $shortcode->parse_typography( $shortcode->atts['mooseoom_submit_typo'] ) );
	}
	
	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'mooseoom_contact_forms_layout2_dynamic_css', 10, 2 );

function mooseoom_contact_forms_layout2_button($form_button)
{

	$form_button['dependency'][1][] = 'mooseoom_layout2';

	return $form_button;
}

add_filter('aheto_button_contact-forms', 'mooseoom_contact_forms_layout2_button', 10, 2);

