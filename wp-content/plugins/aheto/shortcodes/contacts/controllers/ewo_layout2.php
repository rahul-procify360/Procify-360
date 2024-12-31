<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'ewo_contacts_layout2');

/**
 * Contacts
 */

function ewo_contacts_layout2($shortcode)
{

  $preview_dir = '//assets.aheto.co/contacts/previews/';

  $shortcode->add_layout('ewo_layout2', [
    'title' => esc_html__('Contacts 5', 'ewo'),
    'image' => $preview_dir . 'ewo_layout2.jpg',
  ]);

  $shortcode->add_dependecy('ewo_dark_style', 'template', 'ewo_layout2');
  $shortcode->add_dependecy('ewo_contacts_group', 'template', 'ewo_layout2');

  aheto_demos_add_dependency(['use_heading', 't_heading', 'use_content', 't_content'], ['ewo_layout2'], $shortcode);

  $shortcode->add_params([
    'ewo_contacts_group' => [
      'type'    => 'group',
      'heading' => esc_html__('Ewo Contacts', 'ewo'),
      'params'  => [
        'ewo_heading_tag' => [
          'type'    => 'select',
          'heading' => esc_html__('Element tag for Heading', 'ewo'),
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
          'default' => 'h4',
          'grid'    => 5,
        ],
        'ewo_heading'   => [
          'type'    => 'text',
          'heading' => esc_html__('Heading', 'ewo'),
        ],
        'ewo_address'     => [
          'type'    => 'textarea',
          'heading' => esc_html__('Address', 'ewo'),
        ],
        'ewo_phone'       => [
          'type'    => 'text',
          'heading' => esc_html__('Phone', 'ewo'),
        ],
        'ewo_email'       => [
          'type'    => 'text',
          'heading' => esc_html__('Email', 'ewo'),
        ],
      ]
    ],

    'ewo_dark_style' => [
      'type'    => 'switch',
      'heading' => esc_html__('Enable dark style for text?', 'ewo'),
      'grid'    => 3,
    ],
  ]);
}