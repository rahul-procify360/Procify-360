<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'moovit_contact_forms_layout2' );


/**
 * Contact forms
 */

function moovit_contact_forms_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'moovit_layout2', [
		'title' => esc_html__( 'Contact Form 17', 'moovit' ),
		'image' => $preview_dir . 'moovit_layout2.jpg',
	] );

	aheto_demos_add_dependency( ['bg_color_fields', 'title', 'use_title_typo', 'title_typo', 'count_input', 'button_align', 'border_radius_button', 'border_radius_input', 'full_width_button'], [ 'moovit_layout2' ], $shortcode );

	$shortcode->add_dependecy( 'moovit_title_tag', 'template', 'moovit_layout2' );
	$shortcode->add_dependecy( 'moovit_info_message_color', 'template', 'moovit_layout2' );

	$shortcode->add_params( [

		'moovit_title_tag' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Title', 'moovit' ),
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
			'default' => 'h5',
			'grid'    => 5,
		],
		'moovit_info_message_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Info Message text color', 'moovit' ),
            'grid'      => 6,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .wpcf7-response-output' => 'color: {{VALUE}}',
            ],
        ],
	] );


}

function moovit_contact_forms_layout2_button( $form_button ) {

	$form_button['dependency'][1][] = 'moovit_layout2';

	return $form_button;

}

add_filter( 'aheto_button_contact-forms', 'moovit_contact_forms_layout2_button', 10, 2 );

function moovit_contact_forms_layout2_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['moovit_info_message_color']) && !empty($shortcode->atts['moovit_info_message_color'])) {
		$css['global']['%1$s .wpcf7-response-output']['color'] = \Aheto\Sanitize::color($shortcode->atts['moovit_info_message_color']);
	}

	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'moovit_contact_forms_layout2_dynamic_css', 10, 2 );

