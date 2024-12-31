<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'funero_contact_forms_layout2');

/**
 * Contact forms Shortcode
 */

function funero_contact_forms_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/contact-forms/previews/';
	$shortcode->add_layout('funero_layout2', [
		'title' => esc_html__('Contact Form 8', 'funero'),
		'image' => $preview_dir . 'funero_layout2.jpg',
	]);
	aheto_demos_add_dependency(['bg_color_fields','button_align'], ['funero_layout2'], $shortcode);
	$shortcode->add_dependecy('funero_btn_use_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_btn_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_btn_typo', 'funero_btn_use_typo', 'true');

	$shortcode->add_params([
		'funero_btn_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Button?', 'funero'),
			'grid'    => 3,
		],
		'funero_btn_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} input[type="submit"]',
		],
	]);
}

add_filter('aheto_button_contact-forms', 'funero_contact_forms_layout1_button', 10, 2);

function funero_contact_forms_layout2_dynamic_css($css, $shortcode) {
	if ( !empty($shortcode->atts['funero_btn_use_typo']) && !empty($shortcode->atts['funero_btn_typo']) ) {
		\aheto_add_props($css['global']['%1$s input[type="submit"]'], $shortcode->parse_typography($shortcode->atts['funero_btn_typo']));
	}

	return $css;
}
add_filter('aheto_contact_forms_dynamic_css', 'funero_contact_forms_layout2_dynamic_css', 10, 2);
