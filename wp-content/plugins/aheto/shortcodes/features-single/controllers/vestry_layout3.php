<?php

/**
 * Feature Single
 */

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'vestry_features_single_layout3');

function vestry_features_single_layout3($shortcode)
{

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout('vestry_layout3', [
        'title' => esc_html__('Features Single 55', 'vestry'),
        'image' => $preview_dir . 'vestry_layout3.jpg',
    ]);

    aheto_demos_add_dependency(['s_image', 's_heading', 's_description'], ['vestry_layout3'], $shortcode);

    $shortcode->add_dependecy('vestry_icon', 'template', ['vestry_layout3']);

    $shortcode->add_params([
        'vestry_icon' => [
            'type' => 'attach_image',
            'heading' => esc_html__('Icon', 'vestry'),
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group' => esc_html__('Images size for images ', 'vestry'),
        'prefix' => 'vestry_',
        'dependency' => ['template', ['vestry_layout3']]
    ]);
}