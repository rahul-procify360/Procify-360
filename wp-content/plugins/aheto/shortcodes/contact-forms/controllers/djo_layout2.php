<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'djo_contact_forms_layout2');

/**
 * Contact forms Shortcode
 */

function djo_contact_forms_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'djo_layout2', [
		'title' => esc_html__( 'Contact Form 3', 'djo' ),
		'image' => $preview_dir . 'djo_layout2.jpg',
	] );
	aheto_demos_add_dependency(['bg_color_fields', 'title','use_title_typo', 'title_typo', 'count_input','button_align','full_width_button'], ['djo_layout2'], $shortcode);

	$shortcode->add_dependecy( 'djo_title_tag', 'template', 'djo_layout2' );

	$shortcode->add_params([

		'djo_title_tag' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Title', 'djo' ),
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

	]);
}
function djo_contact_forms_layout2_button( $form_button ) {

	$form_button['dependency'][1][] = 'djo_layout2';

	return $form_button;
}

add_filter( 'aheto_button_contact-forms', 'djo_contact_forms_layout2_button', 10, 2 );
