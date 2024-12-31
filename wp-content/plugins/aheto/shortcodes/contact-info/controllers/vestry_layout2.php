<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contact-info_register', 'vestry_contact_info_layout2');

/**
 * Contact Info Type Shortcode
 */

function vestry_contact_info_layout2($shortcode)
{

    $preview_dir = '//assets.aheto.co/contact-info/previews/';

    $shortcode->add_layout('vestry_layout2', [
        'title' => esc_html__('Contact Info 14', 'vestry'),
        'image' => $preview_dir . 'vestry_layout2.jpg',
    ]);

    $shortcode->add_dependecy('vestry_use_background', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_download', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_call', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_copy', 'template', 'vestry_layout2');
    $shortcode->add_dependecy('vestry_audio', 'template', 'vestry_layout2');

    $shortcode->add_params([
        'vestry_use_background' => [
            'type' => 'switch',
            'heading' => esc_html__('Use dark background?', 'vestry'),
            'grid' => 3,
        ],
        'vestry_download' => [
            'type' => 'text',
            'heading' => esc_html__('Download link', 'vestry'),
        ],
        'vestry_call' => [
            'type' => 'text',
            'heading' => esc_html__('Call link', 'vestry'),
        ],
        'vestry_copy' => [
            'type' => 'text',
            'heading' => esc_html__('Copy link', 'vestry'),
        ],
        'vestry_audio' => [
            'type' => 'text',
            'heading' => esc_html__('Audio link', 'vestry'),
        ],
    ]);

    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add dowload icon?', 'vestry'),
        'group' => esc_html__('Audio Icons', 'vestry'),
        'prefix' => 'download_',
        'exclude' => ['align'],
        'dependency' => ['template', ['vestry_layout2']]
    ]);

    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add call icon?', 'vestry'),
        'group' => esc_html__('Audio Icons', 'vestry'),
        'prefix' => 'call_',
        'exclude' => ['align'],
        'dependency' => ['template', ['vestry_layout2']]
    ]);

    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add copy icon?', 'vestry'),
        'group' => esc_html__('Audio Icons', 'vestry'),
        'prefix' => 'copy_',
        'exclude' => ['align'],
        'dependency' => ['template', ['vestry_layout2']]
    ]);

    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add audio icon?', 'vestry'),
        'group' => esc_html__('Audio Icons', 'vestry'),
        'prefix' => 'audio_',
        'exclude' => ['align'],
        'dependency' => ['template', ['vestry_layout2']]
    ]);

}
