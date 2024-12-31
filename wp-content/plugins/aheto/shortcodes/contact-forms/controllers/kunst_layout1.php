<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contact-forms_register', 'kunst_contact_forms_layout1' );

/**
 * Contact forms
 */

function kunst_contact_forms_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout( 'kunst_layout1', [
		'title' => esc_html__( 'Kunst Contact Form Single', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout1.jpg',
	]);

    $shortcode->add_dependecy( 'kunst_use_typo_input', 'template', [ 'kunst_layout1' ] );
    $shortcode->add_dependecy( 'kunst_text_typo_input', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_text_typo_input', 'kunst_use_typo_input', 'true' );

	$shortcode->add_params( [

        'kunst_use_typo_input'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Input?', 'kunst' ),
            'grid'    => 6,
        ],
        'kunst_text_typo_input'   => [
            'type'     => 'typography',
            'group'    => 'Input Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} form input:not([type="submit"]), {{WRAPPER}} .widget_aheto__cf--kunst__subscribe-simple input:not([type="submit"]), {{WRAPPER}} .widget_aheto__cf--kunst__contact-form input:not([type="submit"]), {{WRAPPER}} .widget_aheto__cf--kunst__contact-form select, {{WRAPPER}} .widget_aheto__cf--kunst__contact-form textarea, {{WRAPPER}} .widget_aheto__cf--kunst__contact-form-modern textarea, {{WRAPPER}}, {{WRAPPER}} textarea',

		],

	]);

}

function kunst_contact_forms_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_typo_input']) && !empty($shortcode->atts['kunst_text_typo_input']) ) {
		\aheto_add_props($css['global']['%1$s .widget_aheto__cf--kunst__contact-form input:not([type="submit"]), .widget_aheto__cf--kunst__contact-form textarea'], $shortcode->parse_typography($shortcode->atts['kunst_text_typo_input']));
	}

	return $css;

}

add_filter( 'aheto_dynamic_css_contact_forms', 'kunst_contact_forms_layout1_dynamic_css', 10, 2 );
