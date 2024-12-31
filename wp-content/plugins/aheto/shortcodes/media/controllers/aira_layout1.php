<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_media_register', 'aira_media_layout1' );


/**
 * Simple media
 */
function aira_media_layout1 ($shortcode) {
    $dir = '//assets.aheto.co/media/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Media Single', 'aira' ),
        'image' => $dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy('aira_image', 'template', 'aira_layout1');

    $shortcode->add_params([
        'aira_image'     => [
            'type'    => 'attach_image',
            'heading' => esc_html__('Add image', 'aira' ),
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'dependency' => ['template', ['aira_layout1']]
    ]);
}