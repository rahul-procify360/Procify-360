<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'rela_contact_forms_layout1');


/**
 * Contact forms Shortcode
 */
function rela_contact_forms_layout1($shortcode)
{


    $preview_dir = '//assets.aheto.co/contact-forms/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Contact Form 25', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    aheto_demos_add_dependency('bg_color_fields', ['rela_layout1'], $shortcode);

    $shortcode->add_dependecy('rela_max_width', 'template', 'rela_layout1');


    $shortcode->add_params([
        'rela_max_width' => [
            'type' => 'slider',
            'heading' => esc_html__('Max width', 'rela'),
            'group' => esc_html__('Content', 'rela'),
            'grid' => 6,
            'range' => [
                'px' => [
                    'min' => 10,
                    'max' => 1920,
                    'step' => 5,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .widget_aheto__cf--rela__subscribe-simple' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
            ],
        ],
    ]);
}

function rela_contact_forms_layout1_button($form_button)
{
    $form_button['dependency'][1][] = 'rela_layout1';
    return $form_button;
}

add_filter('aheto_button_contact-forms', 'rela_contact_forms_layout1_button', 10, 2);


function rela_contact_forms_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_max_width'])) {
        $css['global']['%1$s .widget_aheto__cf--rela__subscribe-simple']['max-width'] = Sanitize::size($shortcode->atts['rela_max_width']);
        $css['global']['%1$s .widget_aheto__cf--rela__subscribe-simple']['margin-left'] = 'auto';
        $css['global']['%1$s .widget_aheto__cf--rela__subscribe-simple']['margin-right'] = 'auto';
    }
    return $css;
}

add_filter('aheto_contact_forms_dynamic_css', 'rela_contact_forms_layout1_dynamic_css', 10, 2);