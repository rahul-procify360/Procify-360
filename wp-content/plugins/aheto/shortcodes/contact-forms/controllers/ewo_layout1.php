<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-forms_register', 'ewo_contact_forms_layout1');

/**
 * Contact forms
 */

function ewo_contact_forms_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/contact-forms/previews/';

    $shortcode->add_layout('ewo_layout1', [
        'title' => esc_html__('Contact Form 4', 'ewo'),
        'image' => $preview_dir . 'ewo_layout1.jpg',
    ]);

    $shortcode->add_dependecy('ewo_use_bb_typo', 'template', 'ewo_layout1');
    $shortcode->add_params([
        'ewo_use_bb_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use dark style?', 'ewo'),
            'grid' => 3,
        ],
    ]);
}

function ewo_contact_forms_layout1_button($form_button)
{
    $form_button['dependency'][1][] = 'ewo_layout1';
    return $form_button;
}

add_filter('aheto_button_contact-forms', 'ewo_contact_forms_layout1_button', 10, 2);