<?php

/**
 * The Banner-slider Shortcode.
 */

use Aheto\Helper;
use Aheto\Sanitize;


add_action('aheto_before_aheto_banner-slider_register', 'karma_yoga_banner_slider_layout1');


function karma_yoga_banner_slider_layout1($shortcode){

    $preview_dir = get_template_directory_uri() . '/aheto/banner-slider/previews/';

    $shortcode->add_layout('karma_yoga_layout1', [
        'title' => esc_html__('Yoga Banner-slider', 'karma'),
        'image' => $preview_dir . 'karma_yoga_layout1.jpg',
    ]);


    $shortcode->add_dependecy('karma_yoga_banner', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('subtitle_space1', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('subtitle_space2', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('subtitle_space3', 'template', 'karma_yoga_layout1');

    $shortcode->add_dependecy('karma_yoga_use_title1_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_title1_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_title1_typo', 'karma_yoga_use_title1_typo', 'true');

    $shortcode->add_dependecy('karma_yoga_use_title2_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_title2_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_title2_typo', 'karma_yoga_use_title2_typo', 'true');

    $shortcode->add_dependecy('karma_yoga_use_title3_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_title3_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_title3_typo', 'karma_yoga_use_title3_typo', 'true');


    $shortcode->add_dependecy('karma_yoga_use_subtitle1_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_subtitle1_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_subtitle1_typo', 'karma_yoga_use_subtitle1_typo', 'true');

    $shortcode->add_dependecy('karma_yoga_use_subtitle2_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_subtitle2_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_subtitle2_typo', 'karma_yoga_use_subtitle2_typo', 'true');

    $shortcode->add_dependecy('karma_yoga_use_subtitle3_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_subtitle3_typo', 'template', 'karma_yoga_layout1');
    $shortcode->add_dependecy('karma_yoga_subtitle3_typo', 'karma_yoga_use_subtitle3_typo', 'true');


    $shortcode->add_params([

        'karma_yoga_banner' => [
            'type' => 'group',
            'heading' => esc_html__('Banners', 'karma'),
            'params' => [

                'karma_yoga_slider_style' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Slider Style', 'karma' ),
                    'options' => [
                        'style_1' => esc_html__( 'Style 1', 'karma' ),
                        'style_2'   => esc_html__( 'Style 2', 'karma' ),
                        'style_3'   => esc_html__( 'Style 3', 'karma' ),
                    ],
                    'default' => 'style_1',
                ],

                'karma_yoga_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background Image', 'karma'),
                ],
                'karma_yoga_add_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Additional Image', 'karma'),
                ],
                'karma_yoga_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Title', 'karma'),
                ],
                'karma_yoga_subtitle' => [
                    'type' => 'text',
                    'heading' => esc_html__('Subtitle', 'karma'),
                ],

                'karma_yoga_btn_direction' => [
                    'type' => 'select',
                    'heading' => esc_html__('Buttons Direction', 'karma'),
                    'options' => [
                        '' => esc_html__('Horizontal', 'karma'),
                        'is-vertical' => esc_html__('Vertical', 'karma'),
                    ],
                ],
                'karma_yoga_overlay-color' => [
                    'type' => 'colorpicker',
                    'heading' => esc_html__('Overlay color', 'karma'),
                    'grid' => 6,
                    'selectors' => ['{{WRAPPER}} .swiper-slide-overlay' => 'background-color: {{VALUE}}']
                ],
            ]
        ],

        'subtitle_space1'    => [
            'type'      => 'responsive_spacing',
            'heading'   => esc_html__( 'Margin spaces for Style 1 subtitle', 'karma' ),
            'grid'      => 12,
            'selectors' => [
                '{{WRAPPER}} .slider_style_1 .aheto-banner-slider__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ],
        'subtitle_space2'    => [
            'type'      => 'responsive_spacing',
            'heading'   => esc_html__( 'Margin spaces for Style 2 subtitle', 'karma' ),
            'grid'      => 12,
            'selectors' => [
                '{{WRAPPER}} .slider_style_2 .aheto-banner-slider__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ],
        'subtitle_space3'    => [
            'type'      => 'responsive_spacing',
            'heading'   => esc_html__( 'Margin spaces for Style 3 subtitle', 'karma' ),
            'grid'      => 12,
            'selectors' => [
                '{{WRAPPER}} .slider_style_3 .aheto-banner-slider__subtitle' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ],
        'karma_yoga_use_title1_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Style 1 Title?', 'karma'),
            'grid' => 12,
            'default' => '',
        ],
        'karma_yoga_title1_typo' => [
            'type' => 'typography',
            'group' => 'Style 1 Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .slider_style_1 .aheto-banner-slider__title',
        ],
        'karma_yoga_use_title2_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Style 2 Title?', 'karma'),
            'grid' => 12,
            'default' => '',
        ],
        'karma_yoga_title2_typo' => [
            'type' => 'typography',
            'group' => 'Style 2 Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .slider_style_2 .aheto-banner-slider__title',
        ],
        'karma_yoga_use_title3_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Style 3 Title?', 'karma'),
            'grid' => 12,
            'default' => '',
        ],
        'karma_yoga_title3_typo' => [
            'type' => 'typography',
            'group' => 'Style 3 Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .slider_style_3 .aheto-banner-slider__title',
        ],
        'karma_yoga_use_subtitle1_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Style 1 Subtitle?', 'karma'),
            'grid' => 12,
            'default' => '',
        ],
        'karma_yoga_subtitle1_typo' => [
            'type' => 'typography',
            'group' => 'Style 1 Subtitle Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .slider_style_1 .aheto-banner-slider__subtitle',
        ],
        'karma_yoga_use_subtitle2_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Style 2 Subtitle?', 'karma'),
            'grid' => 12,
            'default' => '',
        ],
        'karma_yoga_subtitle2_typo' => [
            'type' => 'typography',
            'group' => 'Style 2 Subtitle Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .slider_style_2 .aheto-banner-slider__subtitle',
        ],
        'karma_yoga_use_subtitle3_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Style 3 Subtitle?', 'karma'),
            'grid' => 12,
            'default' => '',
        ],
        'karma_yoga_subtitle3_typo' => [
            'type' => 'typography',
            'group' => 'Style 3 Subtitle Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .slider_style_3 .aheto-banner-slider__subtitle',
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'add_button' => true,
        'prefix' => 'karma_yoga_main_',
    ], 'karma_yoga_banner');

    \Aheto\Params::add_button_params($shortcode, [
        'add_button' => true,
        'prefix' => 'karma_yoga_add_',
        'add_label' => esc_html__('Add additional button?', 'karma'),
    ], 'karma_yoga_banner');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'karma_yoga_',
        'include' => ['effect', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
        'dependency' => ['template', ['karma_yoga_layout1']]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'karma_yoga_add_',
        'group' => 'Additional Image size',
        'dependency' => ['template', ['karma_yoga_layout1']]
    ]);
}

function karma_yoga_banner_slider_layout1_dynamic_css($css, $shortcode){

    if ( !empty($this->atts['subtitle_space1']) ) {

        $selector                   = '%1$s .slider_style_1 .aheto-banner-slider__subtitle';
        $this->atts['subtitle_space1'] = Sanitize::responsive_spacing($this->atts['subtitle_space1'], 'margin');

        if ( !empty($this->atts['subtitle_space1']['desktop']) ) {
            \aheto_add_props($css['global'][$selector], $this->atts['subtitle_space1']['desktop']);
        }

        if ( !empty($this->atts['subtitle_space1']['laptop']) ) {
            \aheto_add_props($css['@media (max-width: 1199px)'][$selector], $this->atts['subtitle_space1']['laptop']);
        }

        if ( !empty($this->atts['subtitle_space1']['tablet']) ) {
            \aheto_add_props($css['@media (max-width: 991px)'][$selector], $this->atts['subtitle_space1']['tablet']);
        }

        if ( !empty($this->atts['subtitle_space1']['mobile']) ) {
            \aheto_add_props($css['@media (max-width: 767px)'][$selector], $this->atts['subtitle_space1']['mobile']);
        }
    }

    if ( !empty($this->atts['subtitle_space2']) ) {

        $selector                   = '%1$s .slider_style_2 .aheto-banner-slider__subtitle';
        $this->atts['subtitle_space2'] = Sanitize::responsive_spacing($this->atts['subtitle_space2'], 'margin');

        if ( !empty($this->atts['subtitle_space2']['desktop']) ) {
            \aheto_add_props($css['global'][$selector], $this->atts['subtitle_space2']['desktop']);
        }

        if ( !empty($this->atts['subtitle_space2']['laptop']) ) {
            \aheto_add_props($css['@media (max-width: 1199px)'][$selector], $this->atts['subtitle_space2']['laptop']);
        }

        if ( !empty($this->atts['subtitle_space2']['tablet']) ) {
            \aheto_add_props($css['@media (max-width: 991px)'][$selector], $this->atts['subtitle_space2']['tablet']);
        }

        if ( !empty($this->atts['subtitle_space2']['mobile']) ) {
            \aheto_add_props($css['@media (max-width: 767px)'][$selector], $this->atts['subtitle_space2']['mobile']);
        }
    }

    if ( !empty($this->atts['subtitle_space3']) ) {

        $selector                   = '%1$s .slider_style_3 .aheto-banner-slider__subtitle';
        $this->atts['subtitle_space3'] = Sanitize::responsive_spacing($this->atts['subtitle_space3'], 'margin');

        if ( !empty($this->atts['subtitle_space3']['desktop']) ) {
            \aheto_add_props($css['global'][$selector], $this->atts['subtitle_space3']['desktop']);
        }

        if ( !empty($this->atts['subtitle_space3']['laptop']) ) {
            \aheto_add_props($css['@media (max-width: 1199px)'][$selector], $this->atts['subtitle_space3']['laptop']);
        }

        if ( !empty($this->atts['subtitle_space3']['tablet']) ) {
            \aheto_add_props($css['@media (max-width: 991px)'][$selector], $this->atts['subtitle_space3']['tablet']);
        }

        if ( !empty($this->atts['subtitle_space3']['mobile']) ) {
            \aheto_add_props($css['@media (max-width: 767px)'][$selector], $this->atts['subtitle_space3']['mobile']);
        }
    }

    if (!empty($shortcode->atts['karma_yoga_use_title1_typo']) && !empty($shortcode->atts['karma_yoga_title1_typo'])) {
        \aheto_add_props($css['global']['%1$s .slider_style_1 .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['karma_yoga_title1_typo']));
    }
    if (!empty($shortcode->atts['karma_yoga_use_title2_typo']) && !empty($shortcode->atts['karma_yoga_title2_typo'])) {
        \aheto_add_props($css['global']['%1$s .slider_style_2 .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['karma_yoga_title2_typo']));
    }
    if (!empty($shortcode->atts['karma_yoga_use_title3_typo']) && !empty($shortcode->atts['karma_yoga_title3_typo'])) {
        \aheto_add_props($css['global']['%1$s .slider_style_3 .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['karma_yoga_title3_typo']));
    }

    if (!empty($shortcode->atts['karma_yoga_use_subtitle1_typo']) && !empty($shortcode->atts['karma_yoga_subtitle1_typo'])) {
        \aheto_add_props($css['global']['%1$s .slider_style_1 .aheto-banner-slider__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_yoga_subtitle1_typo']));
    }
    if (!empty($shortcode->atts['karma_yoga_use_subtitle2_typo']) && !empty($shortcode->atts['karma_yoga_subtitle2_typo'])) {
        \aheto_add_props($css['global']['%1$s .slider_style_2 .aheto-banner-slider__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_yoga_subtitle2_typo']));
    }
    if (!empty($shortcode->atts['karma_yoga_use_subtitle3_typo']) && !empty($shortcode->atts['karma_yoga_subtitle3_typo'])) {
        \aheto_add_props($css['global']['%1$s .slider_style_3 .aheto-banner-slider__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_yoga_subtitle3_typo']));
    }

    if (!empty($shortcode->atts['karma_yoga_overlay-color'])) {
        $color = Sanitize::color($shortcode->atts['karma_yoga_overlay-color']);
        $css['global']['%1$s .swiper-slide-overlay']['background-color'] = $color;
    }

    return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'karma_yoga_banner_slider_layout1_dynamic_css', 10, 2);