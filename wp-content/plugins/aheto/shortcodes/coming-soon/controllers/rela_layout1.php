<?php

use Aheto\Helper;

add_action('aheto_before_aheto_coming-soon_register', 'rela_coming_soon_layout1');


/**
 * Coming Soon Shortcode
 */
function rela_coming_soon_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/coming-soon/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Coming Soon 7', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    aheto_demos_add_dependency(['light', 'days_desktop', 'days_mobile', 'hours_desktop', 'hours_mobile', 'mins_desktop', 'mins_mobile', 'secs_desktop', 'secs_mobile', 'use_typo_numbers', 'typo_numbers', 'use_typo_caption', 'typo_caption' ], ['rela_layout1'], $shortcode);

    $shortcode->add_dependecy('rela_use_dots_typo', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_dots_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_dots_typo', 'rela_use_dots_typo', 'true');

    $shortcode->add_params([
        'rela_use_dots_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for dots?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_dots_typo' => [
            'type' => 'typography',
            'group' => 'Rela Dots Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
        ],
    ]);
}

function rela_coming_soon_layout1_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['rela_use_dots_typo']) && !empty($shortcode->atts['rela_dots_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography($shortcode->atts['rela_dots_typo']));
    }

    return $css;
}

add_filter('aheto_coming_soon_dynamic_css', 'rela_coming_soon_layout1_dynamic_css', 10, 2);