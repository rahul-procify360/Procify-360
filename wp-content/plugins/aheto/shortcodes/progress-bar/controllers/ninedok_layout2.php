<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'ninedok_progress_bar_layout2');
/**
 * Progress Bar Shortcode
 */

function ninedok_progress_bar_layout2($shortcode)
{

    $preview_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout('ninedok_layout2', [
        'title' => esc_html__('Progress Bar 15', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout2.jpg',
    ]);

    $shortcode->add_dependecy('ninedok_use_heading_typo', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_overlay_icon', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_use_text_typo', 'template', ['ninedok_layout2']);
    $shortcode->add_dependecy('ninedok_heading_tag', 'template', ['ninedok_layout2']);
    $shortcode->add_dependecy('ninedok_use_number_typo', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_number_typo', 'ninedok_use_number_typo', 'true');
    $shortcode->add_dependecy('ninedok_heading_typo', 'ninedok_use_heading_typo', 'true');
    $shortcode->add_dependecy('ninedok_s_image', 'template', 'ninedok_layout2');

    aheto_demos_add_dependency(['percentage', 'heading'], ['ninedok_layout2'], $shortcode);


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
        'ninedok_s_image' => [
            'type' => 'attach_image',
            'heading' => esc_html__('Image', 'ninedok'),
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
        'ninedok_overlay_icon' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Overlay color', 'ninedok'),
            'grid' => 6,
            'default' => 'transparent',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__image-wrap' => 'background: {{VALUE}}',
            ],
        ],
        'ninedok_use_number_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for numbers?', 'ninedok'),
            'grid' => 4,
        ],
        'ninedok_number_typo' => [
            'type' => 'typography',
            'group' => 'Ninedok Numbers Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number',
        ],


    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'ninedok_',
        'dependency' => ['template', ['ninedok_layout2']]
    ]);

}

function ninedok_progress_bar_layout2_dynamic_css($css, $shortcode)
{


    if (!empty($shortcode->atts['ninedok_overlay_icon'])) {
        $color = Sanitize::color($shortcode->atts['ninedok_overlay_icon']);
        $css['global']['%1$s .aheto-progress__image-wrap']['color'] = $color;
    }
    if (!empty($shortcode->atts['ninedok_use_heading_typo']) && !empty($shortcode->atts['ninedok_heading_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['ninedok_heading_typo']));
    }
    if (!empty($shortcode->atts['ninedok_use_number_typo']) && !empty($shortcode->atts['ninedok_number_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography($shortcode->atts['ninedok_number_typo']));
    }


    return $css;
}

add_filter('aheto_progress_bar_dynamic_css', 'ninedok_progress_bar_layout2_dynamic_css', 10, 2);
