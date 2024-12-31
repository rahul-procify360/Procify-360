<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'bizy_progress_bar_layout2');
/**
 * Progress Bar Shortcode
 */

function bizy_progress_bar_layout2($shortcode) {

    $preview_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout('bizy_layout2', [
        'title' => esc_html__('Bizy Circle', 'bizy'),
        'image' => $preview_dir . 'bizy_layout2.jpg',
    ]);

    $shortcode->add_dependecy('bizy_white_text', 'template', 'bizy_layout2');
    $shortcode->add_dependecy('bizy_add_title_use_typo', 'template', 'bizy_layout2');
    $shortcode->add_dependecy('bizy_add_title_typo', 'template', 'bizy_layout2');
    $shortcode->add_dependecy('bizy_add_title_typo', 'bizy_add_title_use_typo', 'true');

    aheto_demos_add_dependency(['percentage', 'heading'], ['bizy_layout2'], $shortcode);

    $shortcode->add_params([
        'bizy_white_text' => [
            'type'    => 'switch',
            'heading' => esc_html__('Enable light style?', 'bizy'),
            'grid'    => 12,
        ],
        'bizy_add_title_use_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'bizy'),
            'grid'    => 3,
        ],
        'bizy_add_title_typo'     => [
            'type'     => 'typography',
            'group'    => 'Bizy Heading Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title',
        ],
        'bizy_add_chart_symbol_use_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for chart symbol?', 'bizy'),
            'grid'    => 3,
        ],
        'bizy_add_chart_symbol_typo'     => [
            'type'     => 'typography',
            'group'    => 'Bizy Chart Symbol Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__chart-symbol',
        ],
    ]);


}

function bizy_progress_bar_layout2_dynamic_css($css, $shortcode) {

    if ( isset($shortcode->atts['bizy_add_title_use_typo']) && $shortcode->atts['bizy_add_title_use_typo'] && isset($shortcode->atts['bizy_add_title_typo']) && !empty($shortcode->atts['bizy_add_title_typo']) ) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['bizy_add_title_typo']));
    }

    if ( isset($shortcode->atts['bizy_add_chart_symbol_use_typo']) && $shortcode->atts['bizy_add_chart_symbol_use_typo'] && isset($shortcode->atts['bizy_add_chart_symbol_typo']) && !empty($shortcode->atts['bizy_add_chart_symbol_typo']) ) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__chart-symbol'], $shortcode->parse_typography($shortcode->atts['bizy_add_chart_symbol_typo']));
    }

    return $css;
}

add_filter('aheto_progress_bar_dynamic_css', 'bizy_progress_bar_layout2_dynamic_css', 10, 2);
