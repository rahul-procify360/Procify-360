<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_video-btn_register', 'noize_video_btn_layout1' );

/**
 * Video Button Shortcode
 */

function noize_video_btn_layout1( $shortcode ) {
    $preview_dir = '//assets.aheto.co/video-btn/previews/';

    $shortcode->add_layout( 'noize_layout1', [
        'title' => esc_html__( 'Video Button 7', 'noize' ),
        'image' => $preview_dir . 'noize_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'noize_btn_title', 'template', 'noize_layout1' );
    $shortcode->add_dependecy( 'noize_align', 'template', 'noize_layout1' );

    $shortcode->add_params( [
        'noize_btn_title'     => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Title button', 'noize' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Title button with text.', 'noize' ),
        ],
        'align'         => [
            'type'    => 'select',
            'heading' => esc_html__('Align', 'noize'),
            'options' => Helper::choices_alignment(),
            'group'      => esc_html__('General', 'noize'),
        ],
    ] );
}
