<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'ninedok_features_single_layout3');

/**
 * Features Single
 */

function ninedok_features_single_layout3($shortcode)
{

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout('ninedok_layout3', [
        'title' => esc_html__('Features Single 39', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout3.jpg',
    ]);

    aheto_demos_add_dependency(['s_image', 's_heading', 'use_heading', 't_heading', 's_description', 'use_description', 't_description'], ['ninedok_layout3'], $shortcode);

    $shortcode->add_dependecy('ninedok_overlay_icon', 'template', ['ninedok_layout3']);
    $shortcode->add_dependecy('ninedok_align', 'template', ['ninedok_layout3']);

    $shortcode->add_params([
        'ninedok_overlay_icon' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Overlay color', 'ninedok'),
            'grid' => 6,
            'default' => 'transparent',
            'selectors' => [
                '{{WRAPPER}} .aheto-content-block__image-wrap' => 'background: {{VALUE}}',
            ],
        ],
        'ninedok_align' => [
            'type' => 'select',
            'heading' => esc_html__('Align', 'ninedok'),
            'options' => Helper::choices_alignment(),
        ],
    ]);

}

function ninedok_features_single_layout3_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ninedok_overlay_icon'])) {
        $color = Sanitize::color($shortcode->atts['ninedok_overlay_icon']);
        $css['global']['%1$s .aheto-content-block__image-wrap']['background'] = $color;
    }

    return $css;
}

add_filter('aheto_features_single_dynamic_css', 'ninedok_features_single_layout3_dynamic_css', 10, 2);