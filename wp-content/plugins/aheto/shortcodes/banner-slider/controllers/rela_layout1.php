<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'rela_banner_slider_layout1');
/**
 *  Banner Slider
 */

function rela_banner_slider_layout1($shortcode)
{


    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Banner Slider 24', 'rela'),
        'image' => $preview_dir . 'rela_layout2.jpg',
    ]);

    $shortcode->add_dependecy('rela_modern_banners', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_description_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_description_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_description_typo', 'rela_use_description_typo', 'true');

    aheto_demos_add_dependency(['use_heading','t_heading' ], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_use_description_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_description_typo' => [
            'type' => 'typography',
            'group' => 'Rela Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
        ],
        'rela_modern_banners' => [
            'type' => 'group',
            'heading' => esc_html__('Banners', 'rela'),
            'params' => [
                'rela_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background Image', 'rela'),
                ],
                'rela_add_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Additional Image', 'rela'),
                ],
                'rela_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Title', 'rela'),
                ],
                'title_tag'     => [
                    'type'    => 'select',
                    'heading' => esc_html__('Element tag for Title', 'rela'),
                    'options' => [
                        'h1'  => 'h1',
                        'h2'  => 'h2',
                        'h3'  => 'h3',
                        'h4'  => 'h4',
                        'h5'  => 'h5',
                        'h6'  => 'h6',
                        'p'   => 'p',
                        'div' => 'div',
                    ],
                    'default' => 'h2',
                    'grid'    => 5,
                ],
                'rela_desc' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Description', 'rela'),
                ],
                'rela_align' => [
                    'type' => 'select',
                    'heading' => esc_html__('Align', 'rela'),
                    'options' => Helper::choices_alignment(),
                ],
                'rela_btn_direction' => [
                    'type' => 'select',
                    'heading' => esc_html__('Buttons Direction', 'rela'),
                    'options' => [
                        '' => esc_html__('Horizontal', 'rela'),
                        'is-vertical' => esc_html__('Vertical', 'rela'),
                    ],
                ],
                'rela_overlay-color' => [
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Overlay color', 'rela'),
                    'grid' => 6,
                    'selectors' => ['{{WRAPPER}} .swiper-slide-overlay' => 'background-color: {{VALUE}}']
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
                        '{{WRAPPER}} .aheto-banner-slider__desc' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
                    ],
                ],
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
                        '{{WRAPPER}} .aheto-banner__title' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
                    ],
                ],
            ]
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'add_button' => true,
        'prefix' => 'rela_main_',
    ], 'rela_modern_banners');

    \Aheto\Params::add_button_params($shortcode, [
        'add_button' => true,
        'prefix' => 'rela_add_',
        'add_label' => esc_html__('Add additional button?', 'rela'),
    ], 'rela_modern_banners');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'rela_swiper_',
        'include' => ['effect', 'pagination', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'arrows_style','arrows_num_typo', 'arrows_color', 'arrows_size'],
        'dependency' => ['template', ['rela_layout1']]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_add_',
        'group' => 'Additional Image size',
        'dependency' => ['template', ['rela_layout1']]
    ]);
}

function rela_banner_slider_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_description_typo']) && !empty($shortcode->atts['rela_description_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['rela_description_typo']));
    }

    if (!empty($shortcode->atts['rela_overlay-color'])) {
        $color = Sanitize::color($shortcode->atts['rela_overlay-color']);
        $css['global']['%1$s .swiper-slide-overlay']['background-color'] = $color;
    }

    if (!empty($shortcode->atts['rela_desc_max_width'])) {
        $css['global']['%1$s .aheto-banner-slider__desc']['max-width'] = Sanitize::size($shortcode->atts['rela_desc_max_width']);
        $css['global']['%1$s .aheto-banner-slider__desc']['margin-left'] = 'auto';
        $css['global']['%1$s .aheto-banner-slider__desc']['margin-right'] = 'auto';
    }

    if (!empty($shortcode->atts['rela_title_max_width'])) {
        $css['global']['%1$s .aheto-banner__title']['max-width'] = Sanitize::size($shortcode->atts['rela_title_max_width']);
        $css['global']['%1$s .aheto-banner__title']['margin-left'] = 'auto';
        $css['global']['%1$s .aheto-banner__title']['margin-right'] = 'auto';
    }

    return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'rela_banner_slider_layout1_dynamic_css', 10, 2);
