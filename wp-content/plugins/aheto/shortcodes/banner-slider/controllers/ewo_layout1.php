<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'ewo_banner_slider_layout1');

/**
 *  Banner Slider
 */

function ewo_banner_slider_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout('ewo_layout1', [
        'title' => esc_html__('Banner Slider 7', 'aheto'),
        'image' => $preview_dir . 'ewo_layout1.jpg',
    ]);

    aheto_demos_add_dependency(['use_heading', 't_heading'], ['ewo_layout1'], $shortcode);

    $shortcode->add_dependecy('ewo_use_glitch', 'template', 'ewo_layout1');

    $shortcode->add_dependecy('ewo_use_descr_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_descr_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_descr_typo', 'ewo_use_descr_typo', 'true');

    $shortcode->add_dependecy('ewo_modern_banners', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_overlay_color', 'ewo_overlay', 'true');
    $shortcode->add_dependecy('ewo_video_bg', 'ewo_use_video_bg', 'true');


    $shortcode->add_params([
        'ewo_use_glitch' => [
            'type' => 'switch',
            'heading' => esc_html__('Use glitch effect for heading?', 'aheto'),
            'grid' => 3,
        ],
        'ewo_use_descr_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'aheto'),
            'grid' => 3,
        ],

        'ewo_descr_typo' => [
            'type' => 'typography',
            'group' => 'Description Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
        ],
        'ewo_modern_banners' => [
            'type' => 'group',
            'heading' => esc_html__('Banners', 'aheto'),
            'params' => [
                'ewo_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background Image', 'aheto'),
                ],
                'ewo_overlay' => [
                    'type' => 'switch',
                    'heading' => esc_html__('Enable overlay for background image?', 'aheto'),
                    'grid' => 12,
                ],
                'ewo_overlay_color' => [
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Overlay Color', 'aheto'),
                    'grid' => 12,
                    'default' => ''
                ],
                'ewo_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Heading', 'aheto'),
                ],
                'ewo_desc' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Description', 'aheto'),
                ],
                'ewo_video_bg' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background for video button', 'aheto'),
                ],
                'ewo_use_video_bg' => [
                    'type' => 'switch',
                    'heading' => esc_html__('Use background for Video button?', 'aheto'),
                    'grid' => 12,
                ],
            ]
        ],
    ]);

    \Aheto\Params::add_video_button_params($shortcode, [
		'prefix' => 'ewo_',
		'group' => esc_html__('Video Content', 'aheto'),
    ], 'ewo_modern_banners');

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'ewo_main_',
        'add_button' => true,
    ], 'ewo_modern_banners');

    \Aheto\Params::add_button_params($shortcode, [
        'add_label' => esc_html__('Add additional button?', 'aheto'),
        'prefix' => 'ewo_add_',
    ], 'ewo_modern_banners');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'ewo_swiper_',
        'include' => ['effect', 'speed', 'loop', 'arrows', 'autoplay', 'arrows_style', 'arrows_num_typo', 'arrows_color', 'arrows_size', 'arrows_style', 'lazy', 'simulate_touch'],
        'dependency' => ['template', ['ewo_layout1']]
    ]);
}

function ewo_banner_slider_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ewo_use_descr_typo']) && !empty($shortcode->atts['ewo_descr_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['ewo_descr_typo']));
    }

    return $css;
}

add_filter('aheto_banner-slider_dynamic_css', 'ewo_banner_slider_layout1_dynamic_css', 10, 2);