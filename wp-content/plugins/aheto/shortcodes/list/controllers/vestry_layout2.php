<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'vestry_list_layout2');

/**
 * List
 */

function vestry_list_layout2($shortcode)
{
    $dir = '//assets.aheto.co/list/previews/';

    $shortcode->add_layout('vestry_layout2', [
        'title' => esc_html__('List 24', 'vestry'),
        'image' => $dir . 'moovit_layout2.jpg',
    ]);

    $shortcode->add_dependecy('vestry_lists', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_use_list_typo', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_list_typo', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_list_typo', 'vestry_use_list_typo', 'true');

    $shortcode->add_params([
        'vestry_lists' => [
            'type' => 'group',
            'heading' => esc_html__('Link Lists', 'vestry'),
            'params' => [
                'vestry_link_text' => [
                    'type' => 'text',
                    'heading' => esc_html__('Text', 'vestry'),
                ],
                'vestry_link_url' => [
                    'type' => 'link',
                    'heading' => esc_html__('Link', 'vestry'),
                    'description' => esc_html__('Add url to list.', 'vestry'),
                    'default' => [
                        'url' => '#',
                    ],
                ]
            ],
        ],
        'vestry_use_list_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for list?', 'vestry'),
            'grid' => 3,
        ],
        'vestry_list_typo' => [
            'type' => 'typography',
            'group' => 'Vestry List Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .vestry-list-links',
        ],
    ]);
}

function vestry_list_layout2_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['vestry_use_list_typo']) && !empty($shortcode->atts['vestry_list_typo'])) {
        \aheto_add_props($css['global']['%1$s .vestry-list-links'], $shortcode->parse_typography($shortcode->atts['vestry_list_typo']));
    }

    return $css;
}

add_filter('aheto_list_dynamic_css', 'vestry_list_layout2_dynamic_css', 10, 2);