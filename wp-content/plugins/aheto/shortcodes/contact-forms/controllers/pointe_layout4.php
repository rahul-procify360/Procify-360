<?php


use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'pointe_contact_forms_layout4');

/**
 * Contact forms
 */

function pointe_contact_forms_layout4($shortcode)
{

	$preview_dir = '//assets.aheto.co/contact-forms/previews/';

	$shortcode->add_layout('pointe_layout4', [
        'title' => esc_html__('Pointe request', 'pointe'),
        'image' => $preview_dir . 'pointe_layout4.jpg',
    ]);

    $shortcode->add_dependecy('pointe_use_text_typo', 'template', 'pointe_layout4');
    $shortcode->add_dependecy('pointe_text_typo', 'template', 'pointe_layout4');
    $shortcode->add_dependecy('pointe_text_typo', 'pointe_use_text_typo', 'true');

    $shortcode->add_dependecy('pointe_title_tag', 'template', 'pointe_layout4');

	aheto_demos_add_dependency(['title', 'bg_color_fields', 'use_title_typo', 'title_typo', 'count_input', 'button_align', 'full_width_button'], ['pointe_layout4'], $shortcode);
   
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
        ],

        'pointe_title_tag'   => [
            'type'    => 'select',
            'heading' => esc_html__('Element tag for Title', 'pointe'),
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

function pointe_contact_forms_layout4_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_use_text_typo']) && !empty($shortcode->atts['pointe_text_typo'])) {
        \aheto_add_props($css['global']['%1$s p input:not([type=submit]), %1$s .wpcf7 textarea'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
    }
	
	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'pointe_contact_forms_layout4_dynamic_css', 10, 2 );

function pointe_contact_forms_layout4_button($form_button)
{

	$form_button['dependency'][1][] = 'pointe_layout4';

	return $form_button;
}

add_filter('aheto_button_contact-forms', 'pointe_contact_forms_layout4_button', 10, 2);
