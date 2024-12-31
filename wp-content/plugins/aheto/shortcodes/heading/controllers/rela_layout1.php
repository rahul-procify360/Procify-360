<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'rela_heading_layout1');


/**
 * Heading Shortcode
 */
function rela_heading_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/heading/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Heading 18', 'rela'),
        'image' => $shortcode_dir . 'ewo_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_desc_max_width', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_title_max_width', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_description_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_description_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_description_typo', 'rela_use_description_typo', 'true');

    aheto_demos_add_dependency(['use_typo', 'text_typo', 'heading', 'use_typo_hightlight', 'text_typo_hightlight', 'description', 'alignment', 'text_tag'], ['rela_layout1'], $shortcode);
    $shortcode->add_params([
        'rela_title_max_width' => [
            'type' => 'slider',
            'heading' => esc_html__('Title Max width', 'rela'),
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
                '{{WRAPPER}} .aheto-heading__title' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ],
        'rela_desc_max_width' => [
            'type' => 'slider',
            'heading' => esc_html__('Description Max width', 'rela'),
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
                '{{WRAPPER}} .aheto-heading__desc' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
            ],
        ],
        'rela_use_description_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Description?', 'rela'),
            'grid' => 3,
        ],
        'rela_description_typo' => [
            'type' => 'typography',
            'group' => 'Description Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__desc',
        ]
    ]);
}

function rela_heading_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_description_typo']) && !empty($shortcode->atts['rela_description_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography($shortcode->atts['rela_description_typo']));
    }

    if (!empty($shortcode->atts['rela_title_max_width'])) {
        $css['global']['%1$s .aheto-heading__title']['max-width'] = Sanitize::size($shortcode->atts['rela_title_max_width']);
    }

    if (!empty($shortcode->atts['rela_desc_max_width'])) {
        $css['global']['%1$s .aheto-heading__desc']['max-width'] = Sanitize::size($shortcode->atts['rela_desc_max_width']);
        $css['global']['%1$s .aheto-heading__desc']['margin-left'] = 'auto';
        $css['global']['%1$s .aheto-heading__desc']['margin-right'] = 'auto';
    }
    return $css;
}

add_filter('aheto_heading_dynamic_css', 'rela_heading_layout1_dynamic_css', 10, 2);
