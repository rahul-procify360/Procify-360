<?php

use Aheto\Helper;

add_action('aheto_before_aheto_video-btn_register', 'rela_video_btn_layout1');

/**
 * Video Button
 */
function rela_video_btn_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/video-btn/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Video Button 9', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_text', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_text_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_text_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_text_typo', 'rela_use_text_typo', 'true');
    $shortcode->add_dependecy( 'rela_triangle_color', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_text_position', 'template', 'rela_layout1');

    $shortcode->add_params([
        'rela_text' => [
            'type' => 'text',
            'heading' => esc_html__('Text for video button', 'rela'),
        ],
        'rela_use_text_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for text?', 'rela'),
            'grid' => 3,
        ],
        'rela_text_position' => [
            'type' => 'switch',
            'heading' => esc_html__('Move text to right?', 'rela'),
            'grid' => 3,
            'default'   => true,
        ],
        'rela_text_typo' => [
            'type' => 'typography',
            'group' => 'Text Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-btn-video__text',
        ],
        'rela_triangle_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Triangle color', 'rela' ),
            'grid'      => 6,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .js-video-btn.aheto-btn-video' => 'color: {{VALUE}}',
            ],
        ],
    ]);
}

function rela_video_btn_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_text_typo']) && !empty($shortcode->atts['rela_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-btn-video__text'], $shortcode->parse_typography($shortcode->atts['rela_text_typo']));
    }
    if ( ! empty( $shortcode->atts['rela_triangle_color'] ) ) {
        $color                                                    = Sanitize::color( $shortcode->atts['rela_triangle_color'] );
        $css['global']['%1$s .js-video-btn.aheto-btn-video']['color'] = $color;
    }

    return $css;
}

add_filter('aheto_video_btn_dynamic_css', 'rela_video_btn_layout1_dynamic_css', 10, 2);

