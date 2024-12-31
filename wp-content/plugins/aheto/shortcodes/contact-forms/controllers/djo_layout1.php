<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'djo_contact_forms_layout1');

/**
 * Contact forms Shortcode
 */

function djo_contact_forms_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'djo_layout1', [
		'title' => esc_html__( 'Contact Form 2', 'djo' ),
		'image' => $preview_dir . 'djo_layout1.jpg',
	] );
	
	aheto_demos_add_dependency('bg_color_fields', ['djo_layout1'], $shortcode);
	$shortcode->add_dependecy( 'djo_use_input', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_input_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_input_typo', 'djo_use_input', 'true' );
	$shortcode->add_params( [
		'djo_use_input' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for input?', 'djo' ),
			'grid'    => 6,
		],

		'djo_input_typo' => [
			'type'     => 'typography',
			'group'    => 'Input Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} input',
		],
	] );
}
function djo_contact_forms_layout1_button( $form_button ) {

	$form_button['dependency'][1][] = 'djo_layout1';

	return $form_button;
}

add_filter( 'aheto_button_contact-forms', 'djo_contact_forms_layout1_button', 10, 2 );

function djo_contact_forms_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_input']) && $shortcode->atts['djo_use_input'] && isset($shortcode->atts['djo_input_typo']) && !empty($shortcode->atts['djo_input_typo']) ) {
		\aheto_add_props($css['global']['%1$s input'], $shortcode->parse_typography($shortcode->atts['djo_input_typo']));
	}

	return $css;
}

add_filter('aheto_contact_forms_dynamic_css', 'djo_contact_forms_layout1_dynamic_css', 10, 2);
