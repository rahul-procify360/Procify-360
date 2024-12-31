<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'rela_media_layout1');

/**
 * Simple media
 */
function rela_media_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/media/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Media 19', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_image', 'template', 'rela_layout1');

    $shortcode->add_params([
        'rela_image' => [
            'type' => 'attach_image',
            'heading' => esc_html__('Add image', 'rela'),
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_',
        'dependency' => ['template', ['rela_layout1']]
    ]);
}