<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'soapy_banner_slider_layout1');

/**
 *  Banner Slider
 */

function soapy_banner_slider_layout1($shortcode) {

    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout('soapy_layout1', [
        'title' => esc_html__('Banner Slider 27', 'soapy'),
        'image' => $preview_dir . 'soapy_layout1.jpg',
    ]);

    $shortcode->add_dependecy('soapy_simple_banners', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_title_use_typo', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_title_typo', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_title_typo', 'soapy_title_use_typo', 'true');
    $shortcode->add_dependecy('soapy_subtitle_use_typo', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_subtitle_typo', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_subtitle_typo', 'soapy_subtitle_use_typo', 'true');
    $shortcode->add_dependecy('soapy_b_bottom', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_b_bottom', 'soapy_border', 'true');
    $shortcode->add_dependecy('soapy_b_top', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_b_top', 'soapy_border', 'true');
    $shortcode->add_dependecy('soapy_arrow_use_typo', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_arrow_typo', 'template', 'soapy_layout1');
    $shortcode->add_dependecy('soapy_arrow_typo', 'soapy_arrow_use_typo', 'true');

    $shortcode->add_params([
        'soapy_simple_banners' => [
            'type' => 'group',
            'heading' => esc_html__('Banners', 'soapy'),
            'params' => [
                'soapy_image_bg' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background Image', 'soapy'),
                ],
                'soapy_border' => [
                    'type' => 'switch',
                    'heading' => esc_html__('Add border image?', 'soapy'),
                    'grid' => 12,
                ],
                'soapy_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Image Before Subtitle', 'soapy'),
                ],
                'soapy_b_top' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Border Top Image', 'soapy'),
                ],
                'soapy_b_bottom' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Border Bottom Image', 'soapy'),
                ],
                'soapy_content_border' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Content Border Image ', 'soapy'),
                ],
                'soapy_subtitle' => [
                    'type' => 'text',
                    'heading' => esc_html__('Subtitle', 'soapy'),
                ],
                'soapy_subtitle_spaces' => [
                    'type' => 'switch',
                    'heading' => esc_html__('Remove space under subtitle?', 'soapy'),
                    'grid' => 12,
                ],
                'soapy_image_subtitle' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Subtitle Background', 'soapy'),
                ],
                'soapy_title' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Title', 'soapy'),
                ],
                'soapy_title_tag' => [
                    'type' => 'select',
                    'heading' => esc_html__('Element tag for Title', 'soapy'),
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
                    'default' => 'h1',
                    'grid' => 5,
                ],
                'soapy_align' => [
                    'type' => 'select',
                    'heading' => esc_html__('Align', 'soapy'),
                    'options' => \Aheto\Helper::choices_alignment(),
                ],
                'soapy_overlay' => [
                    'type' => 'select',
                    'heading' => esc_html__('Overlay', 'soapy'),
                    'options' => [
                        '' => 'None',
                        'light' => 'Light',
                        'dark' => 'Dark',
                    ],
                    'default' => '',
                    'grid' => 5,
                ],
            ]
        ],
        'soapy_title_use_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'soapy'),
            'grid' => 3,
        ],
        'soapy_title_typo' => [
            'type' => 'typography',
            'group' => 'Soapy Heading Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__title',
        ],
        'soapy_subtitle_use_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for subtitle?', 'soapy'),
            'grid' => 3,
        ],
        'soapy_subtitle_typo' => [
            'type' => 'typography',
            'group' => 'Soapy Subtitle Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__subtitle',
        ],
        'soapy_arrow_use_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for arrow?', 'soapy'),
            'grid' => 3,
        ],
        'soapy_arrow_typo' => [
            'type' => 'typography',
            'group' => 'Swiper',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider .swiper-button-next, {{WRAPPER}} .aheto-banner-slider  .swiper-button-prev',
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'add_button' => true,
        'prefix' => 'soapy_main_',
        'include' => ['style'],
    ], 'soapy_simple_banners');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'soapy_swiper_simple_',
        'include' => ['effect', 'speed', 'loop', 'autoplay', 'arrows', 'arrows_style'],
        'dependency' => ['template', ['soapy_layout1']]
    ]);

}

function soapy_banner_slider_layout1_dynamic_css($css, $shortcode) {
    if (isset($shortcode->atts['soapy_title_use_typo']) && $shortcode->atts['soapy_title_use_typo'] && isset($shortcode->atts['soapy_title_typo']) && !empty($shortcode->atts['soapy_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['soapy_title_typo']));
    }
    if (isset($shortcode->atts['soapy_arrow_use_typo']) && $shortcode->atts['soapy_arrow_use_typo'] && isset($shortcode->atts['soapy_arrow_typo']) && !empty($shortcode->atts['soapy_arrow_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider .swiper-button-next, %1$s .aheto-banner-slider  .swiper-button-prev'], $shortcode->parse_typography($shortcode->atts['soapy_arrow_typo']));
    }
    if (isset($shortcode->atts['soapy_subtitle_use_typo']) && $shortcode->atts['soapy_subtitle_use_typo'] && isset($shortcode->atts['soapy_subtitle_typo']) && !empty($shortcode->atts['soapy_subtitle_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider__subtitle'], $shortcode->parse_typography($shortcode->atts['soapy_subtitle_typo']));
    }

    return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'soapy_banner_slider_layout1_dynamic_css', 10, 2);
