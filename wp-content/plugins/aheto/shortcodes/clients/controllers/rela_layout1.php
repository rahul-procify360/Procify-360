<?php

use Aheto\Helper;


add_action('aheto_before_aheto_clients_register', 'rela_clients_layout1');


/**
 * Clients Shortcode
 */
function rela_clients_layout1($shortcode){

    $preview_dir = '//assets.aheto.co/clients/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Clients 6', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_hover_style', 'template', 'rela_layout1');

    aheto_demos_add_dependency(['clients', 'item_per_row'], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_hover_style' => [
            'type' => 'select',
            'heading' => esc_html__('Hover Style', 'rela'),
            'default' => 'default',
            'options' => [
                'default' => esc_html__('Default', 'rela'),
                'grayscale' => esc_html__('Grayscale', 'rela'),
                'darkness' => esc_html__('Darkness', 'rela'),
                'opacity_d' => esc_html__('Opacity decrease', 'rela'),
            ],
        ]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_',
        'dependency' => ['template', 'rela_layout1']
    ]);
}
