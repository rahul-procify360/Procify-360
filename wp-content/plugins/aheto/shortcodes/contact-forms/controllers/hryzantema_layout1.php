<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'hryzantema_contact_forms_layout1');

/**
 * Contact forms Shortcode
 */

function hryzantema_contact_forms_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Contact Form 9', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );

	aheto_demos_add_dependency(['title', 'use_title_typo', 'title_typo', 'full_width_button', 'count_input', 'button_align', 'border_radius_button', 'border_radius_input', 'bg_color_fields'], ['hryzantema_layout1' ], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_max_width', 'template', 'hryzantema_layout1' );

	$shortcode->add_params([
		'hryzantema_max_width'    => [
			'type'      => 'slider',
			'heading'   => esc_html__('Form Max width', 'hryzantema'),
			'grid'      => 4,
			'size_units' => [ 'px', '%', 'vh' ],
			'range'     => [
				'px' => [
					'min'  => 200,
					'max'  => 2000,
					'step' => 5,
				],
				'%' => [
					'min'  => 0,
					'max'  => 100,
				],
				'vh' => [
					'min'  => 0,
					'max'  => 100,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .widget_aheto__form' => 'max-width: {{SIZE}}{{UNIT}}; margin: auto;',
			],
		],
	]);
}
function hryzantema_contact_forms_layout1_button( $form_button ) {

	$form_button['dependency'][1][] = 'hryzantema_layout1';

	return $form_button;
}

add_filter( 'aheto_button_contact-forms', 'hryzantema_contact_forms_layout1_button', 10, 2 );
