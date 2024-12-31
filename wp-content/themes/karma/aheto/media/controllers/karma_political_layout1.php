<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_media_register', 'karma_political_media_layout1' );

/**
 * Simple media
 */
function karma_political_media_layout1($shortcode) {

    $preview_dir = get_template_directory_uri() . '/aheto/media/previews/';

    $shortcode->add_layout( 'karma_political_layout1', [
        'title' => esc_html__( 'Karma Media Simple', 'karma' ),
        'image' => $preview_dir . 'karma_political_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'karma_political_image', 'template', 'karma_political_layout1' );

    $shortcode->add_params([
        'karma_political_image'     => [
            'type'    => 'attach_images',
            'heading' => esc_html__('Add image', 'karma' ),
        ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'karma_political_',
        'dependency' => ['template', ['karma_political_layout1']]
    ] );
    
}