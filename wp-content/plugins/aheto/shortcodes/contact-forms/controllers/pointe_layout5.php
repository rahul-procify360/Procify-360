<?php


use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'pointe_contact_forms_layout5');

/**
 * Contact forms
 */

function pointe_contact_forms_layout5($shortcode)
{

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('pointe_layout5', [
        'title' => esc_html__('Pointe contact us', 'pointe'),
        'image' => $preview_dir . 'pointe_layout5.jpg',
    ]);

    $shortcode->add_dependecy('pointe_use_text_typo', 'template', 'pointe_layout5');
    $shortcode->add_dependecy('pointe_text_typo', 'template', 'pointe_layout5');
    $shortcode->add_dependecy('pointe_text_typo', 'pointe_use_text_typo', 'true');

	aheto_demos_add_dependency(['bg_color_fields', 'use_title_typo', 'title_typo', 'count_input', 'button_align', 'full_width_button'], ['pointe_layout5'], $shortcode);
   
	$shortcode->add_params([
		
        'pointe_use_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Text?', 'pointe'),
            'grid'    => 2,
        ],

        'pointe_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe text Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} p input:not([type=submit]), {{WRAPPER}} .wpcf7 textarea',
        ]
	]);
}

function pointe_contact_forms_layout5_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_use_text_typo']) && !empty($shortcode->atts['pointe_text_typo'])) {
        \aheto_add_props($css['global']['%1$s p input:not([type=submit]), %1$s .wpcf7 textarea'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
    }
	
	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'pointe_contact_forms_layout5_dynamic_css', 10, 2 );

function pointe_contact_forms_layout5_button($form_button)
{

	$form_button['dependency'][1][] = 'pointe_layout5';

	return $form_button;
}

add_filter('aheto_button_contact-forms', 'pointe_contact_forms_layout5_button', 10, 2);
