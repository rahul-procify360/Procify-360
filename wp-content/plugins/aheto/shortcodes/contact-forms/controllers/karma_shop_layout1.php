<?php


use Aheto\Helper;

add_action ( 'aheto_before_aheto_contact-forms_register', 'karma_shop_contact_forms_layout1' );

/**
 * Contact forms
 */

function karma_shop_contact_forms_layout1 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode -> add_layout ( 'karma_shop_layout1', [
		'title' => esc_html__ ( 'Contact Form 12', 'karma_shop' ),
		'image' => $preview_dir . 'karma_shop_layout1.jpg',
	] );

	aheto_demos_add_dependency( 'bg_color_fields', [ 'karma_shop_layout1' ], $shortcode );
	$shortcode -> add_dependecy ( 'karma_shop_title', 'template', 'karma_shop_layout1' );
	$shortcode -> add_dependecy ( 'karma_shop_use_title_typo', 'template', 'karma_shop_layout1' );
	$shortcode -> add_dependecy ( 'karma_shop_title_typo', 'template', 'karma_shop_layout1' );
	$shortcode -> add_dependecy ( 'karma_shop_title_typo', 'karma_shop_use_title_typo', 'true' );

	$shortcode -> add_dependecy ( 'karma_shop_use_error_typo', 'template', 'karma_shop_layout1' );
	$shortcode -> add_dependecy ( 'karma_shop_error_typo', 'template', 'karma_shop_layout1' );
	$shortcode -> add_dependecy ( 'karma_shop_error_typo', 'karma_shop_use_error_typo', 'true' );

	$shortcode -> add_dependecy ( 'karma_shop_use_input_typo', 'template', 'karma_shop_layout1' );
	$shortcode -> add_dependecy ( 'karma_shop_input_typo', 'template', 'karma_shop_layout1' );
	$shortcode -> add_dependecy ( 'karma_shop_input_typo', 'karma_shop_use_input_typo', 'true' );

	$shortcode -> add_dependecy('karma_shop_error_bprder_color', 'template', 'karma_shop_layout1');

	$shortcode->add_params( [
		'karma_shop_title' => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'karma'),
			'grid'    => 6,
		],
		'karma_shop_use_title_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for title?', 'karma' ),
			'grid' => 3,
		],
		'karma_shop_title_typo' => [
			'type' => 'typography',
			'group' => 'Karma shop Title Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .widget_aheto__form-title',
		],
		
		'karma_shop_use_error_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for error message', 'karma' ),
			'grid' => 3,
		],
		'karma_shop_error_typo' => [
			'type' => 'typography',
			'group' => 'Karma shop Error Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.wpcf7-validation-errors',
		],
		'karma_shop_use_input_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for input', 'karma' ),
			'grid' => 3,
		],
		'karma_shop_input_typo' => [
			'type' => 'typography',
			'group' => 'Karma Shop Input Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} input:not([type="submit"])',
		],
		'karma_shop_error_bprder_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Border error color', 'karma'),
			'selectors' => ['{{WRAPPER}} div.wpcf7-validation-errors' => 'border-color: {{VALUE}};'],
		]
	] );
}
function karma_shop_contact_forms_layout1_dynamic_css ( $css, $shortcode )
{

	if ( isset( $this->atts['karma_shop_use_title_typo'] ) && $this->atts['karma_shop_use_title_typo']  && isset($this->atts['karma_shop_title_typo']) && ! empty( $this->atts['karma_shop_title_typo'] ) ) {
		\aheto_add_props ( $css['global']['%1$s  .widget_aheto__form-title'], $shortcode -> parse_typography ( $shortcode -> atts['karma_shop_title_typo'] ) );
	}
	
	if ( isset( $this->atts['karma_shop_use_error_typo'] ) && $this->atts['karma_shop_use_error_typo']  && isset($this->atts['karma_shop_error_typo']) && ! empty( $this->atts['karma_shop_error_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s div.wpcf7-validation-errors'], $this->parse_typography( $this->atts['karma_shop_error_typo'] ) );
	}
	if ( isset( $this->atts['karma_shop_use_input_typo'] ) && $this->atts['karma_shop_use_input_typo']  && isset($this->atts['karma_shop_input_typo']) && ! empty( $this->atts['karma_shop_input_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s input:not([type="submit"])'], $this->parse_typography( $this->atts['karma_shop_input_typo'] ) );
	}


	if (isset($shortcode->atts['karma_shop_error_bprder_color']) && !empty($shortcode->atts['karma_shop_error_bprder_color'])) {
		$css['global']['%1$s div.wpcf7-validation-errors']['border-color'] = \Aheto\Sanitize::color($shortcode->atts['karma_shop_error_bprder_color']);
	}
	
	return $css;
}

add_filter ( 'aheto_contact_forms_dynamic_css', 'karma_shop_contact_forms_layout1_dynamic_css', 10, 2 );

function karma_shop_contact_forms_layout1_button ( $form_button )
{

	$form_button['dependency'][1][] = 'karma_shop_layout1';

	return $form_button;

}

add_filter ( 'aheto_button_contact-forms', 'karma_shop_contact_forms_layout1_button', 10, 2 );

