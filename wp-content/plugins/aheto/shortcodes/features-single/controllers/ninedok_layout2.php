<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'ninedok_features_single_layout2');

/**
 * Features Single
 */

function ninedok_features_single_layout2($shortcode)
{

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout('ninedok_layout2', [
        'title' => esc_html__('Features Single 38', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout2.jpg',
    ]);

    aheto_demos_add_dependency(['s_image', 's_heading', 'use_heading', 't_heading', 's_description', 'use_description', 't_description'], ['ninedok_layout2'], $shortcode);

    $shortcode->add_dependecy('ninedok_overlay', 'template', ['ninedok_layout2']);

    $shortcode->add_params([
        'ninedok_overlay' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Overlay color', 'ninedok'),
            'grid' => 6,
            'default' => 'transparent',
            'selectors' => [
                '{{WRAPPER}} .aheto-content-block__overlay' => 'background: {{VALUE}}',
            ],
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'ninedok_',
        'dependency' => ['template', ['ninedok_layout2']]
    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'add_butun' => true,
        'prefix' => 'ninedok_',
        'dependency' => ['template', ['ninedok_layout2']]
    ]);
}

function ninedok_features_single_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ninedok_overlay'])) {
        $color = Sanitize::color($shortcode->atts['ninedok_overlay']);
        $css['global']['%1$s .aheto-content-block__overlay']['background'] = $color;
    }

    return $css;
}

add_filter('aheto_features_single_dynamic_css', 'ninedok_features_single_layout2_dynamic_css', 10, 2);