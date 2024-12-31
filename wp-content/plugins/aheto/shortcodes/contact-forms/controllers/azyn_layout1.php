<?php
use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'azyn_contact_forms_layout1' );

/**
 * Contact forms
 */

function azyn_contact_forms_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'azyn_layout1', [
		'title' => esc_html__( 'Azyn Contact Form', 'aheto' ),
		'image' => $preview_dir . 'azyn_layout1.jpg',
	] );

	$shortcode->add_dependecy('azyn_disable_creative_btn', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_border_color_fields', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_color_placeholder', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_use_text_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_text_typo', 'template', 'azyn_layout1');
	$shortcode->add_dependecy('azyn_text_typo', 'azyn_use_text_typo', 'true');

	$shortcode->add_params([
		'azyn_border_color_fields'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Border color', 'aheto'),
			'selectors' => ['{{WRAPPER}} .wpcf7 input, {{WRAPPER}} .wpcf7 textarea' => 'border-color: {{VALUE}}'],
		],
		'azyn_color_placeholder'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Placeholder color', 'aheto'),
			'selectors' => ['{{WRAPPER}} .wpcf7 textarea::placeholder,
			{{WRAPPER}} .wpcf7 input:not([type=submit])::placeholder' => 'color: {{VALUE}}; -webkit-text-fill-color: {{VALUE}};'],
		],
		'azyn_use_text_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for text?', 'aheto' ),
			'grid'    => 4,
		],
		'azyn_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} form span > input, {{WRAPPER}} form span > textarea',
		],
		'azyn_disable_creative_btn'  => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Disable creative button?', 'aheto' ),
			'grid'    => 4,
		],
	]);

	\Aheto\Params::add_button_params( $shortcode, [
		'add_button' => false,
		'prefix'     => 'azyn_form_',
		'layouts' => 'layout1',
		'link' => false,
		'include'    => [
			'style',
			'underline',
		],
		'dependency' => [ 'template', ['azyn_layout1'] ]
	] );

}

function azyn_contact_forms_layout1_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['azyn_border_color_fields']) && !empty($shortcode->atts['azyn_border_color_fields'])) {
		$css['global']['%1$s .wpcf7 input, %1$s .wpcf7 textarea']['border-color'] = \Aheto\Sanitize::color($shortcode->atts['azyn_border_color_fields']);
	}

	if (isset($shortcode->atts['azyn_color_placeholder']) && !empty($shortcode->atts['azyn_color_placeholder'])) {
		$css['global']['%1$s .wpcf7 textarea::placeholder, %1$s .wpcf7 input:not([type=submit])::placeholder']['color'] = \Aheto\Sanitize::color($shortcode->atts['azyn_color_placeholder']);
		$css['global']['%1$s .wpcf7 textarea::placeholder, %1$s .wpcf7 input:not([type=submit])::placeholder']['-webkit-text-fill-color'] = \Aheto\Sanitize::color($shortcode->atts['azyn_color_placeholder']);
	}

	return $css;

}
add_filter('aheto_contact_forms_dynamic_css', 'azyn_contact_forms_layout1_dynamic_css', 10, 2);

function azyn_contact_forms_layout1_button( $form_button ) {

	$form_button['dependency'][1][] = 'azyn_layout1';

	return $form_button;

}

add_filter( 'aheto_button_contact-forms', 'azyn_contact_forms_layout1_button', 10, 2 );

