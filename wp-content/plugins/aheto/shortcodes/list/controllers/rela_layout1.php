<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'rela_list_layout1');

/**
 * List Shortcode
 */
function rela_list_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/list/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('List 22', 'rela'),
        'image' => $shortcode_dir . 'acacio_layout4.jpg',
    ]);

    aheto_demos_add_dependency(['lists', 'heading', 'text_tag', 'color'], ['rela_layout1'], $shortcode);
}
