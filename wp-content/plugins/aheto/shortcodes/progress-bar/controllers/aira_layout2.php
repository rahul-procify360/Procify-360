<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_progress-bar_register', 'aira_progress_bar_layout2' );



/**
 * Progress Bar Shortcode
 */

function aira_progress_bar_layout2( $shortcode ) {

    $theme_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout('aira_layout2', [
        'title' => esc_html__('Aira Round', 'aira'),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ]);


    $shortcode->add_dependecy( 'aira_use_count_descr_typo', 'template', 'aira_layout2');
    $shortcode->add_dependecy( 'aira_count_descr_typo', 'aira_use_count_descr_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_count_title_typo', 'template', 'aira_layout2');
    $shortcode->add_dependecy( 'aira_count_title_typo', 'aira_use_count_title_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_count_number_typo', 'template', 'aira_layout2');
    $shortcode->add_dependecy( 'aira_count_number_typo', 'aira_use_count_number_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_count_symbol_typo', 'template', 'aira_layout2');
    $shortcode->add_dependecy( 'aira_count_symbol_typo', 'aira_use_count_symbol_typo', 'true' );

    aheto_demos_add_dependency( ['description','percentage','heading'], [ 'aira_layout2'], $shortcode );

    $shortcode->add_params( [
        'aira_use_count_symbol_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Symbol?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_count_symbol_typo' => [
            'type'     => 'typography',
            'group'    => 'Symbol Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__chart-symbol i',
        ],
        'aira_use_count_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Title?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_count_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title',
        ],
        'aira_use_count_descr_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Description?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_count_descr_typo' => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__desc',
        ],
        'aira_use_count_number_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Number?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_count_number_typo' => [
            'type'     => 'typography',
            'group'    => 'Number Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__chart-symbol',
        ],
    ] );

}

function aira_progress_bar_layout2_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['aira_use_count_descr_typo']) && !empty($shortcode->atts['aira_count_descr_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__desc'], $shortcode->parse_typography($shortcode->atts['aira_count_descr_typo']));
    }
    if (!empty($shortcode->atts['aira_use_count_title_typo']) && !empty($shortcode->atts['aira_count_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['aira_count_title_typo']));
    }
    if (!empty($shortcode->atts['aira_use_count_number_typo']) && !empty($shortcode->atts['aira_count_number_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__chart-symbol'], $shortcode->parse_typography($shortcode->atts['aira_count_number_typo']));
    }
    return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'aira_progress_bar_layout2_dynamic_css', 10, 2 );
