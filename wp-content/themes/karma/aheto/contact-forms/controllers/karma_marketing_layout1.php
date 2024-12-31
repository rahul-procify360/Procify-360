<?php


use Aheto\Helper;

add_action ( 'aheto_before_aheto_contact-forms_register', 'karma_marketing_contact_forms_layout1' );

/**
 * Contact forms
 */

function karma_marketing_contact_forms_layout1 ( $shortcode )
{

	$preview_dir = get_template_directory_uri() . '/aheto/contact-forms/previews/';

	$shortcode -> add_layout ( 'karma_marketing_layout1', [
		'title' => esc_html__ ( 'Karma Marketing Subscribe line', 'karma_marketing' ),
		'image' => $preview_dir . 'karma_marketing_layout1.jpg',
	] );

	karma_add_dependency( 'bg_color_fields', [ 'karma_marketing_layout1' ], $shortcode );
	$shortcode -> add_dependecy ( 'karma_marketing_use_submit_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_submit_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_submit_typo', 'karma_marketing_use_submit_typo', 'true' );
	
	$shortcode -> add_dependecy ( 'karma_marketing_use_error_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_error_typo', 'template', 'karma_marketing_layout1' );
	$shortcode -> add_dependecy ( 'karma_marketing_error_typo', 'karma_marketing_use_error_typo', 'true' );
	
	$shortcode -> add_dependecy('karma_marketing_error_bprder_color', 'template', 'karma_marketing_layout1');

	$shortcode->add_params( [
		'karma_marketing_use_submit_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for Submit Button?', 'karma' ),
			'grid' => 3,
		],
		'karma_marketing_submit_typo' => [
			'type' => 'typography',
			'group' => 'Karma marketing Submit Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} input[type="submit"]',
		],
		
		'karma_marketing_use_error_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for error message', 'karma' ),
			'grid' => 3,
		],
		'karma_marketing_error_typo' => [
			'type' => 'typography',
			'group' => 'Karma marketing Error Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} div.wpcf7-validation-errors',
		],
		'karma_marketing_error_bprder_color'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Border error color', 'karma'),
			'selectors' => ['{{WRAPPER}} div.wpcf7-validation-errors' => 'border-color: {{VALUE}};'],
		]
	] );
}
function karma_marketing_contact_forms_layout1_dynamic_css ( $css, $shortcode )
{

	if ( isset( $this->atts['karma_marketing_use_submit_typo'] ) && $this->atts['karma_marketing_use_submit_typo']  && isset($this->atts['karma_marketing_submit_typo']) && ! empty( $this->atts['karma_marketing_submit_typo'] ) ) {
		\aheto_add_props ( $css['global']['%1$s  input[type="submit"]'], $shortcode -> parse_typography ( $shortcode -> atts['karma_marketing_submit_typo'] ) );
	}
	
	if ( isset( $this->atts['karma_marketing_use_error_typo'] ) && $this->atts['karma_marketing_use_error_typo']  && isset($this->atts['karma_marketing_error_typo']) && ! empty( $this->atts['karma_marketing_error_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s div.wpcf7-validation-errors'], $this->parse_typography( $this->atts['karma_marketing_error_typo'] ) );
	}


	if (isset($shortcode->atts['karma_marketing_error_bprder_color']) && !empty($shortcode->atts['karma_marketing_error_bprder_color'])) {
		$css['global']['%1$s div.wpcf7-validation-errors']['border-color'] = \Aheto\Sanitize::color($shortcode->atts['karma_marketing_error_bprder_color']);
	}
	
	return $css;
}

add_filter ( 'aheto_contact_forms_dynamic_css', 'karma_marketing_contact_forms_layout1_dynamic_css', 10, 2 );

function karma_marketing_contact_forms_layout1_button ( $form_button )
{

	$form_button['dependency'][1][] = 'karma_marketing_layout1';

	return $form_button;

}

add_filter ( 'aheto_button_contact-forms', 'karma_marketing_contact_forms_layout1_button', 10, 2 );

