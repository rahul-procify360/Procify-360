<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_media_register', 'aira_media_layout2' );


/**
 * Simple media
 */
function aira_media_layout2 ($shortcode) {
    $dir = '//assets.aheto.co/media/previews/';

    $shortcode->add_layout('aira_layout2', [
        'title' => esc_html__('Aira Media Gallery', 'aira'),
        'image' => $dir . 'aira_layout2.jpg',
    ]);

    $shortcode->add_dependecy('aira_images', 'template', 'aira_layout2');

    $shortcode->add_params([
        'aira_images'     => [
            'type'    => 'attach_images',
            'heading' => esc_html__('Add images', 'aira' ),
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'dependency' => ['template', ['aira_layout2']]
    ]);
}