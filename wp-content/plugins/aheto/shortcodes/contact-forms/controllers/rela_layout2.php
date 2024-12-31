<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'rela_contact_forms_layout2');


/**
 * Contact forms Shortcode
 */
function rela_contact_forms_layout2($shortcode)
{


    $preview_dir = '//assets.aheto.co/contact-forms/previews/';

    $shortcode->add_layout('rela_layout2', [
        'title' => esc_html__('Contact Form 26', 'rela'),
        'image' => $preview_dir . 'rela_layout2.jpg',
    ]);

    aheto_demos_add_dependency(['title', 'use_title_typo', 'title_typo', 'button_align', 'border_radius_button', 'border_radius_input', 'bg_color_fields', 'full_width_button' ], ['rela_layout2'], $shortcode);

    $shortcode->add_dependecy('rela_title_tag', 'template', 'rela_layout2');
    $shortcode->add_dependecy( 'rela_color_error', 'template', 'rela_layout2');

    $shortcode->add_params([

        'rela_color_error'    => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__('Color error message', 'rela'),
			'selectors' => ['{{WRAPPER}} div.wpcf7-validation-errors' => 'color: {{VALUE}}; border-color: {{VALUE}};'],
		],

        'rela_title_tag' => [
            'type' => 'select',
            'heading' => esc_html__('Element tag for Title', 'rela'),
            'options' => [
                'h1' => 'h1',
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h6' => 'h6',
                'p' => 'p',
                'div' => 'div',
            ],
            'default' => 'h5',
            'grid' => 5,
        ],
    ]);
}

function rela_contact_forms_layout2_dynamic_css( $css, $shortcode ) {

	if (isset($shortcode->atts['rela_color_error']) && !empty($shortcode->atts['rela_color_error'])) {
		$css['global']['%1$s div.wpcf7-validation-errors']['color'] = \Aheto\Sanitize::color($shortcode->atts['rela_color_error']);
		$css['global']['%1$s div.wpcf7-validation-errors']['border-color'] = \Aheto\Sanitize::color($shortcode->atts['rela_color_error']);
	}
	
	return $css;
}

add_filter( 'aheto_contact_forms_dynamic_css', 'rela_contact_forms_layout2_dynamic_css', 10, 2 );

function rela_contact_forms_layout2_button($form_button)
{
    $form_button['dependency'][1][] = 'rela_layout2';
    return $form_button;
}

add_filter('aheto_button_contact-forms', 'rela_contact_forms_layout2_button', 10, 2);