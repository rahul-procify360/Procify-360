<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'ninedok_progress_bar_layout1');
/**
 * Progress Bar Shortcode
 */

function ninedok_progress_bar_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout('ninedok_layout1', [
        'title' => esc_html__('Progress Bar 14', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout1.jpg',
    ]);

    $shortcode->add_dependecy('ninedok_text_color', 'template', ['ninedok_layout1']);
    $shortcode->add_dependecy('ninedok_line_color', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_active_color', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_use_heading_typo', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_use_text_typo', 'template', ['ninedok_layout1']);
    $shortcode->add_dependecy('ninedok_number_typo', 'ninedok_use_number_typo', 'true');
    $shortcode->add_dependecy('ninedok_heading_typo', 'ninedok_use_heading_typo', 'true');
    $shortcode->add_dependecy('ninedok_heading_tag', 'template', ['ninedok_layout1']);
    $shortcode->add_dependecy('ninedok_text_typo', 'ninedok_use_text_typo', 'true');

    aheto_demos_add_dependency(['percentage', 'heading'], ['ninedok_layout1'], $shortcode);


    $shortcode->add_params([
        'ninedok_heading_tag' => [
            'type' => 'select',
            'heading' => esc_html__('Element tag for heading', 'ninedok'),
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
        'ninedok_use_heading_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'ninedok'),
            'grid' => 4,
        ],
        'ninedok_heading_typo' => [
            'type' => 'typography',
            'group' => 'Ninedok Heading Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__heading',
        ],
        'ninedok_use_text_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for percent?', 'ninedok'),
            'grid' => 3,
        ],
        'ninedok_text_typo' => [
            'type' => 'typography',
            'group' => 'Ninedok Percent Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title, {{WRAPPER}} .aheto-progress__bar-perc',
        ],
        'ninedok_line_color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Line color', 'ninedok'),
            'grid' => 6,
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__bar' => 'background: {{VALUE}}',
            ],
        ],
        'ninedok_active_color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Active line color', 'ninedok'),
            'grid' => 6,
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__bar-val' => 'background: {{VALUE}}',
                '{{WRAPPER}} .aheto-progress__bar-val::before' => 'background: {{VALUE}}',
            ],
        ],
    ]);


}

function ninedok_progress_bar_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ninedok_use_heading_typo']) && !empty($shortcode->atts['ninedok_heading_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['ninedok_heading_typo']));
    }
    if (!empty($shortcode->atts['ninedok_use_text_typo']) && !empty($shortcode->atts['ninedok_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__heading'], $shortcode->parse_typography($shortcode->atts['ninedok_text_typo']));
    }
    if (!empty($shortcode->atts['ninedok_use_text_typo']) && !empty($shortcode->atts['ninedok_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['ninedok_text_typo']));
        \aheto_add_props($css['global']['%1$s .aheto-progress__bar-perc'], $shortcode->parse_typography($shortcode->atts['ninedok_text_typo']));
    }
    if (!empty($shortcode->atts['ninedok_active_color'])) {
        $color = Sanitize::color($shortcode->atts['ninedok_active_color']);
        $css['global']['%1$s .aheto-progress__bar-val']['background'] = $color;
        $css['global']['%1$s .aheto-progress__bar-val::before']['background'] = $color;
    }


    return $css;
}

add_filter('aheto_progress_bar_dynamic_css', 'ninedok_progress_bar_layout1_dynamic_css', 10, 2);
