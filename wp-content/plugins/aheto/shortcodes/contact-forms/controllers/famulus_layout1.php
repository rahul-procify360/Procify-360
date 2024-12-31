<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'famulus_contact_forms_layout1');

/**
 * Contact forms Shortcode
 */

function famulus_contact_forms_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Contact Form 6', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	aheto_demos_add_dependency(['bg_color_fields', 'title', 'use_title_typo', 'title_typo', 'count_input', 'button_align', 'full_width_button' ], ['famulus_layout1'], $shortcode);

	$shortcode->add_dependecy('famulus_title_tag', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_hide_border', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_error_color', 'template', 'famulus_layout1');

	$shortcode->add_params([

		'famulus_error_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Border and text error color', 'famulus'),
			'selectors' => ['{{WRAPPER}} div.wpcf7-validation-errors, {{WRAPPER}} span.wpcf7-not-valid-tip' => 'border-color: {{VALUE}}; color: {{VALUE}}'],
		],

		'famulus_title_tag'   => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Title', 'famulus'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h3',
			'grid'    => 5,
		],
		'famulus_hide_border' => [
			'type'    => 'switch',
			'heading' => esc_html__('Hide Border', 'famulus'),
			'grid'    => 3,
		],
	]);
}

function famulus_contact_forms_layout1_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['famulus_error_color']) && !empty($shortcode->atts['famulus_error_color'])) {
		$css['global']['%1$s div.wpcf7-validation-errors']['border-color'] = \Aheto\Sanitize::color($shortcode->atts['famulus_error_color']);
		$css['global']['%1$s div.wpcf7-validation-errors, %1$s span.wpcf7-not-valid-tip']['color'] = \Aheto\Sanitize::color($shortcode->atts['famulus_error_color']);
	}
	
	return $css;
	
}
add_filter('aheto_contact_forms_dynamic_css', 'famulus_contact_forms_layout1_dynamic_css', 10, 2);

function famulus_contact_forms_layout1_button($form_button) {

	$form_button['dependency'][1][] = 'famulus_layout1';

	return $form_button;
}

add_filter('aheto_button_contact-forms', 'famulus_contact_forms_layout1_button', 10, 2);

