<?php


use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'pointe_contact_forms_layout2');

/**
 * Contact forms
 */

function pointe_contact_forms_layout2($shortcode)
{

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('pointe_layout2', [
        'title' => esc_html__('Pointe full width', 'pointe'),
        'image' => $preview_dir . 'pointe_layout2.jpg',
    ]);



    $shortcode->add_dependecy('pointe_btn-bg_color', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_btn-bg_hover_color', 'template', ['pointe_layout2']);

	$shortcode->add_params([
		
        'pointe_btn-bg_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__('Btn bg color', 'pointe'),
            'grid'      => 6,
            'default'   => 'transparent',
            'selectors' => [
                '{{WRAPPER}} input[type=submit]' => 'background: {{VALUE}}',
            ],
        ],
        'pointe_btn-bg_hover_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__('Btn bg hover color', 'pointe'),
            'grid'      => 6,
            'default'   => 'transparent',
            'selectors' => [
                '{{WRAPPER}} input[type=submit]:hover' => 'background: {{VALUE}}',
            ],
        ],

	]);
}

function pointe_contact_forms_layout2_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_use_text_typo']) && !empty($shortcode->atts['pointe_text_typo'])) {
        \aheto_add_props($css['global']['%1$s p input:not([type=submit]), %1$s .wpcf7 textarea'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
    }
	
	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'pointe_contact_forms_layout2_dynamic_css', 10, 2 );

function pointe_contact_forms_layout2_button($form_button)
{

	$form_button['dependency'][1][] = 'pointe_layout2';

	return $form_button;
}

add_filter('aheto_button_contact-forms', 'pointe_contact_forms_layout2_button', 10, 2);
