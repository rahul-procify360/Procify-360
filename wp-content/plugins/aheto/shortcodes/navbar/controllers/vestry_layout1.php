<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'vestry_navbar_layout1');


/**
 * Navbar
 */

function vestry_navbar_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/navbar/previews/';

    $shortcode->add_layout('vestry_layout1', [
        'title' => esc_html__('Navbar 16', 'vestry'),
        'image' => $preview_dir . 'vestry_layout1.jpg',
    ]);


    $shortcode->add_dependecy('vestry_left_links', 'template', 'vestry_layout1');

    $shortcode->add_dependecy('vestry_use_links_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_links_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_links_typo', 'vestry_use_links_typo', 'true');

    $shortcode->add_params([
        'vestry_left_links' => [
            'type' => 'group',
            'heading' => esc_html__('Left links', 'vestry'),
            'params' => [
                'vestry_type_link' => [
                    'type' => 'select',
                    'heading' => esc_html__('Type of link', 'vestry'),
                    'options' => [
                        'phone' => esc_html__('Phone', 'vestry'),
                        'address' => esc_html__('Address', 'vestry'),
                    ],
                ],
                'vestry_add_icon' => [
                    'type' => 'switch',
                    'heading' => esc_html__('Add icon before label?', 'vestry'),
                    'grid' => 6,
                    'default' => '',
                ],
                'vestry_address' => [
                    'type' => 'text',
                    'heading' => esc_html__('Address', 'vestry'),
                ],
                'vestry_phone' => [
                    'type' => 'text',
                    'heading' => esc_html__('Phone', 'vestry'),
                ],
            ],
        ],
        'vestry_use_links_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for links?', 'vestry'),
            'grid' => 6,
        ],
        'vestry_links_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Links Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-navbar--item, {{WRAPPER}} .aheto-navbar--item-link',
        ],
    ]);
}


function vestry_navbar_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['vestry_use_links_typo']) && !empty($shortcode->atts['vestry_links_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-navbar--item, %1$s .aheto-navbar--item -link'], $shortcode->parse_typography($shortcode->atts['vestry_links_typo']));
    }

    return $css;
}

add_filter('aheto_navbar_dynamic_css', 'vestry_navbar_layout2_dynamic_css', 10, 2);