<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'rela_contents_layout1');

/**
 * Contents Shortcode
 */
function rela_contents_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/contents/previews/';


    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Content 29', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    aheto_demos_add_dependency(['faqs', 'multi_active', 'first_is_opened'], ['rela_layout1'], $shortcode);

    $shortcode->add_dependecy( 'rela_icon_size', 'template', 'rela_layout1' );


    $shortcode->add_params( [
        'rela_icon_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Icon size', 'rela'),
            'description' => esc_html__( 'Enter icon font size with units.', 'rela' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-contents__item i' => 'font-size: {{VALUE}}'],
        ],
    ] );
}

function rela_contents_layout1_dynamic_css($css, $shortcode)
{

    if ( !empty($shortcode->atts['rela_icon_size']) ) {
        $css['global']['%1$s .aheto-contents__item i']['font-size'] = Sanitize::size( $shortcode->atts['rela_icon_size'] );
    }

    return $css;
}

add_filter('aheto_contents_dynamic_css', 'rela_contents_layout1_dynamic_css', 10, 2);