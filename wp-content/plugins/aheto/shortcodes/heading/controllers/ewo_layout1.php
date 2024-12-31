<?php

use Aheto\Helper;

add_action('aheto_before_aheto_heading_register', 'ewo_heading_layout1');

/**
 * Heading
 */
function ewo_heading_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/heading/previews/';

    $shortcode->add_layout('ewo_layout1', [
        'title' => esc_html__('Heading 4', 'ewo'),
        'image' => $preview_dir . 'ewo_layout1.jpg',
    ]);

    $shortcode->add_dependecy('ewo_subtitle', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_subtitle_tag', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_use_subtitle_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_subtitle_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_subtitle_typo', 'ewo_use_subtitle_typo', 'true');

    aheto_demos_add_dependency(['heading', 'text_typo', 'alignment', 'use_typo_hightlight', 'text_typo_hightlight', 'text_tag', 'use_typo', 'title_animation'], ['ewo_layout1'], $shortcode);

    $shortcode->add_params([
        'text_typo_hightlight' => [
            'type' => 'typography',
            'group' => 'Hightlight Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__title span',
        ],
        'ewo_subtitle' => [
            'type' => 'textarea',
            'heading' => esc_html__('Description', 'ewo'),
            'description' => esc_html__('Add some text for description', 'ewo'),
            'admin_label' => true,
            'default' => esc_html__('Add some text for description', 'ewo'),
        ],
        'ewo_subtitle_tag' => [
            'type' => 'select',
            'heading' => esc_html__('Element tag for description', 'ewo'),
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
            'default' => 'p',
            'grid' => 5,
        ],
        'ewo_use_subtitle_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'ewo'),
            'grid' => 3,
        ],

        'ewo_subtitle_typo' => [
            'type' => 'typography',
            'group' => 'Description Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
        ],

    ]);
}

function ewo_heading_layout1_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['ewo_use_subtitle_typo']) && !empty($shortcode->atts['ewo_subtitle_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography($shortcode->atts['ewo_subtitle_typo']));
    }
    return $css;
}

add_filter('aheto_heading_dynamic_css', 'ewo_heading_layout1_dynamic_css', 10, 2);