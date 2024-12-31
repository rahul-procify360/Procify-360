<?php

use Aheto\Helper;

add_action('aheto_before_aheto_clients_register', 'ewo_clients_layout1');

/**
 *  Banner Slider
 */

function ewo_clients_layout1($shortcode)
{

  $preview_dir = '//assets.aheto.co/clients/previews/';

  $shortcode->add_layout('ewo_layout1', [
    'title' => esc_html__('Clients 1', 'ewo'),
    'image' => $preview_dir . 'ewo_layout1.jpg',
  ]);

  aheto_demos_add_dependency( ['hover_style', 'clients', 'item_per_row'], [ 'ewo_layout1' ], $shortcode );
}