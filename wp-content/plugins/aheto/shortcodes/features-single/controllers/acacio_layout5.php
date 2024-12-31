<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-single_register', 'acacio_features_single_layout5' );

/**
 * Features Single
 */

function acacio_features_single_layout5( $shortcode )
{

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout('acacio_layout5', [
        'title' => esc_html__('Features Single 5', 'acacio'),
        'image' => $preview_dir . 'acacio_layout5.jpg',
    ]);

    aheto_demos_add_dependency(['s_heading', 'use_heading', 't_heading', 's_description', 's_image', 'use_description', 't_description'], ['acacio_layout5'], $shortcode);

    $shortcode->add_dependecy('acacio_active', 'template', ['acacio_layout5']);

    // Acacio Modern with subtitle

    $shortcode->add_dependecy('acacio_add_subtitle', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_subtitle', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_subtitle', 'acacio_add_subtitle', 'true');

    $shortcode->add_dependecy('acacio_use_subtitle_typo', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_subtitle_typo', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_subtitle_typo', 'acacio_use_subtitle_typo', 'true');

    $shortcode->add_dependecy('acacio_use_end_symbol', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_end_symbol', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_end_symbol', 'acacio_use_end_symbol', 'true');

    $shortcode->add_dependecy('acacio_end_symbol_typo', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_end_symbol_typo', 'acacio_use_end_symbol_typo', 'true');
    $shortcode->add_dependecy('acacio_use_end_symbol_typo', 'template', 'acacio_layout5');
    $shortcode->add_dependecy('acacio_use_end_symbol_typo', 'acacio_use_end_symbol', 'true');


    $shortcode->add_params([
        'acacio_add_subtitle' => [
            'type' => 'switch',
            'heading' => esc_html__('Use subtitle?', 'acacio'),
        ],
        
        'acacio_subtitle' => [
            'type' => 'textarea',
            'heading' => esc_html__('Add your subtitle', 'acacio'),
            'grid' => '3',
        ],
        'acacio_use_subtitle_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for title?', 'acacio'),
            'grid' => 3,
        ],

        'acacio_subtitle_typo' => [
            'type' => 'typography',
            'group' => 'Subtitle Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-block__subtitle',
        ],
        
        
        'acacio_active' => [
            'type' => 'switch',
            'heading' => esc_html__('Mark as active?', 'acacio'),
            'grid' => 12,
        ],
        'acacio_use_end_symbol' => [
            'type' => 'switch',
            'heading' => esc_html__('Use end symbol for title?', 'acacio'),
            'grid' => 3,
        ],
        'acacio_end_symbol' => [
            'type' => 'text',
            'heading' => esc_html__('End symbol for title', 'acacio')
        ],
        'acacio_use_end_symbol_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use end symbol typography?', 'acacio'),
            'grid' => 3,
        ],
        'acacio_end_symbol_typo' => [
            'type' => 'typography',
            'group' => 'End symbol typo Typography',
            'settings' => [
                'tag' => true,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-content-block__title span',
        ],

    ]);
    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'acacio_main_',
        'dependency' => ['template', ['acacio_layout5']]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group' => esc_html__('Images size for images ', 'acacio'),
        'prefix' => 'acacio_',
        'dependency' => ['template', ['acacio_layout5']]
    ]);

}


function acacio_features_single_layout5_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['acacio_use_end_symbol_typo'] ) && ! empty( $shortcode->atts['acacio_end_symbol_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-content-block__title span'], $shortcode->parse_typography( $shortcode->atts['acacio_end_symbol_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['acacio_use_subtitle_typo'] ) && ! empty( $shortcode->atts['acacio_subtitle_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-content-block__subtitle'], $shortcode->parse_typography( $shortcode->atts['acacio_subtitle_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_features-single_dynamic_css', 'acacio_features_single_layout5_dynamic_css', 10, 2 );