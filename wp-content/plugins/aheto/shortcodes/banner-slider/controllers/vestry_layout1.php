<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'vestry_banner_slider_layout1');

/**
 *  Banner Slider
 */

function vestry_banner_slider_layout1($shortcode) {

    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout('vestry_layout1', [
        'title' => esc_html__('Banner Slider 29', 'vestry'),
        'image' => $preview_dir . 'vestry_layout1.jpg',
    ]);

    $shortcode->add_dependecy('vestry_modern_banners', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_overlay_color', 'vestry_overlay', 'true');

    $shortcode->add_dependecy('vestry_use_subtitle_typo', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_subtitle_typo', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_subtitle_typo', 'vestry_use_subtitle_typo', 'true');

    $shortcode->add_dependecy('vestry_use_title_typo', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_title_typo', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_title_typo', 'vestry_use_title_typo', 'true');

    $shortcode->add_dependecy('vestry_use_desc_typo', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_desc_typo', 'template', ['vestry_layout1']);
    $shortcode->add_dependecy('vestry_desc_typo', 'vestry_use_desc_typo', 'true');

    $shortcode->add_params([
        'vestry_modern_banners' => [
            'type' => 'group',
            'heading' => esc_html__('Banners', 'vestry'),
            'params' => [
                'vestry_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background Image', 'vestry'),
                ],
                'vestry_overlay' => [
                    'type' => 'switch',
                    'heading' => esc_html__('Enable overlay for background image?', 'vestry'),
                    'grid' => 12,
                ],
                'vestry_overlay_color' => [
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Overlay Color', 'vestry'),
                    'grid' => 12,
                    'default' => ''
                ],
                'vestry_sub_title' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Subtitle', 'vestry'),
                ],
                'vestry_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Title', 'vestry'),
                ],
                'vestry_desc' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Description', 'vestry'),
                ],
            ]
        ],
        'vestry_use_subtitle_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for subtitle?', 'vestry'),
            'grid' => 3,
        ],
        'vestry_subtitle_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Subtitle Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__sub-title',
        ],
        'vestry_use_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'vestry'),
            'grid' => 3,
        ],
        'vestry_title_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Heading Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__title',
        ],
        'vestry_use_desc_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'vestry'),
            'grid' => 3,
        ],
        'vestry_desc_typo' => [
            'type' => 'typography',
            'group' => 'Vestry Description Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__descr',
        ],
    ]);

    \Aheto\Params::add_video_button_params($shortcode, [
        'add_label' => esc_html__('Add video?', 'vestry'),
        'prefix' => 'vestry_video_',
        'group' => esc_html__('Video Content', 'vestry'),
    ], 'vestry_modern_banners');

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'vestry_main_',
    ], 'vestry_modern_banners');

    \Aheto\Params::add_button_params($shortcode, [
        'add_label' => esc_html__('Add additional button?', 'vestry'),
        'prefix' => 'vestry_add_',
    ], 'vestry_modern_banners');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'vestry_swiper_',
        'include' => ['effect', 'pagination', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
        'dependency' => ['template', ['vestry_layout1']]
    ]);
}

function vestry_banner_slider_layout1_dynamic_css($css, $shortcode) {
    if (!empty($shortcode->atts['vestry_title_use_typo']) && !empty($shortcode->atts['vestry_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['vestry_title_typo']));
    }
    if (!empty($shortcode->atts['vestry_subtitle_use_typo']) && !empty($shortcode->atts['vestry_subtitle_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider__subtitle'], $shortcode->parse_typography($shortcode->atts['vestry_subtitle_typo']));
    }

    return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'vestry_banner_slider_layout1_dynamic_css', 10, 2);