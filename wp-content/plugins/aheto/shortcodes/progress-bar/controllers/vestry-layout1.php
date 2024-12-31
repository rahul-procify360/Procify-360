<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'vestry_progress_bar_layout1');

/**
 * Progress Bar Shortcode
 */

function vestry_progress_bar_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout('vestry_layout1', [
        'title' => esc_html__('Progress Bar 19', 'vestry'),
        'image' => $preview_dir . 'vestry_layout1.jpg',
    ]);

    $shortcode->add_dependecy('vestry_number', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_use_number_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_number_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_number_typo', 'vestry_use_number_typo', 'true');

    aheto_demos_add_dependency(['heading', 'description'], ['vestry_layout1'], $shortcode);
    $shortcode->add_dependecy('vestry_title_tag', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_use_heading_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_heading_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_heading_typo', 'vestry_use_heading_typo', 'true');

    $shortcode->add_dependecy('vestry_use_description_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_description_typo', 'template', 'vestry_layout1');
    $shortcode->add_dependecy('vestry_description_typo', 'vestry_use_description_typo', 'true');


    $shortcode->add_params([
        'vestry_number' => [
            'type' => 'text',
            'heading' => esc_html__('Number', 'vestry'),
        ],
        'vestry_use_number_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for numbers?', 'vestry'),
            'grid' => 6,
        ],
        'vestry_number_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Numbers Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number',
        ],
        'vestry_title_tag' => [
            'type' => 'select',
            'heading' => esc_html__('Element tag for heading', 'vestry'),
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
            'default' => 'h4',
            'grid' => 1,
        ],
        'vestry_use_heading_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'vestry'),
            'grid' => 6,
        ],
        'vestry_heading_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Heading Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title',
        ],
        'vestry_use_description_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'vestry'),
            'grid' => 6,
        ],
        'vestry_description_typo' => [
            'type' => 'typography',
            'group' => 'Vestry description Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__desc',
        ],
    ]);
}


function vestry_progress_bar_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['vestry_use_number_typo']) && !empty($shortcode->atts['vestry_number_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography($shortcode->atts['vestry_number_typo']));
    }
    if (!empty($shortcode->atts['vestry_use_heading_typo']) && !empty($shortcode->atts['vestry_heading_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['vestry_heading_typo']));
    }
    if (!empty($shortcode->atts['vestry_use_description_typo']) && !empty($shortcode->atts['vestry_description_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__desc'], $shortcode->parse_typography($shortcode->atts['vestry_description_typo']));
    }

    return $css;
}

add_filter('aheto_progress_bar_dynamic_css', 'vestry_progress_bar_layout1_dynamic_css', 10, 2);