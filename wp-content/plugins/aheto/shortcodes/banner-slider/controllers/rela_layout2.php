<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'rela_banner_slider_layout2');

/**
 *  Banner Slider
 */
function rela_banner_slider_layout2($shortcode){

    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout('rela_layout2', [
        'title' => esc_html__('Banner Slider 25', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_creative_banners', 'template', 'rela_layout2');

    $shortcode->add_dependecy('rela_use_pagination_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_pagination_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_pagination_typo', 'rela_use_pagination_typo', 'true');

    $shortcode->add_params([
        'rela_use_pagination_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for pagination?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_pagination_typo' => [
            'type' => 'typography',
            'group' => 'Pagination Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .swiper-pagination--numeric .swiper-pagination',
        ],
        'rela_creative_banners' => [
            'type' => 'group',
            'heading' => esc_html__('Banners', 'rela'),
            'params' => [
                'rela_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background Image', 'rela'),
                ]
            ]
        ]
    ]);

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'rela_swiper_creative_',
        'include' => ['effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'pagination'],
        'dependency' => ['template', ['rela_layout2']]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_creative_',
        'dependency' => ['template', ['rela_layout2']]
    ]);
}

function rela_banner_slider_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_pagination_typo']) && !empty($shortcode->atts['rela_pagination_typo'])) {
        \aheto_add_props($css['global']['%1$s .swiper-pagination--numeric .swiper-pagination'], $shortcode->parse_typography($shortcode->atts['rela_pagination_typo']));
    }

    return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'rela_banner_slider_layout2_dynamic_css', 10, 2);
