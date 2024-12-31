<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'bizy_features_single_layout2');

/**
 * Features Single
 */

function bizy_features_single_layout2($shortcode)
{

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout('bizy_layout2', [
        'title' => esc_html__('Bizy Creative', 'bizy'),
        'image' => $preview_dir . 'bizy_layout2.jpg',
    ]);

    aheto_demos_add_dependency(['t_heading', 'use_heading'], ['bizy_layout2'], $shortcode);

    $shortcode->add_dependecy( 'bizy_columns', 'template', 'bizy_layout2' );
    $shortcode->add_dependecy( 'bizy_features_creative', 'template', 'bizy_layout2' );

    $shortcode->add_params([
        'bizy_columns' => [
            'type' => 'select',
            'heading' => esc_html__('Count of columns', 'bizy'),
            'options' => [
                'one' => 'One',
                'two' => 'Two',
                'three' => 'Three',
                'four' => 'Four',
            ],
            'default' => 'one',
        ],
        'bizy_features_creative' => [
            'type' => 'group',
            'heading' => esc_html__('Bizy Features Items', 'bizy'),
            'params' => [
                'bizy_item_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Image', 'bizy'),
                ],
                'bizy_hover_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Hover image', 'bizy'),
                ],
                'bizy_item_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Title', 'bizy'),
                    'admin_label' => true,
                    'default' => esc_html__('Title', 'bizy'),
                ],
            ]
        ],


    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group' => esc_html__('Bizy Images Size', 'aheto'),
        'prefix' => 'bizy_',
        'dependency' => ['template', ['bizy_layout2']]
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'group' => esc_html__('Bizy Button Settings', 'aheto'),
        'prefix' => 'bizy_btn_',
        'icons' => true,
        'include'    => [
            'style',
            'size',
            'type',
            'shadow',
            'underline',
        ],
    ], 'bizy_features_creative');
}