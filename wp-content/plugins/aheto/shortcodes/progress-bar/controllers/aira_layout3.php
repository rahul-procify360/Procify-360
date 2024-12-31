<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_progress-bar_register', 'aira_progress_bar_layout3' );



/**
 * Progress Bar Shortcode
 */

function aira_progress_bar_layout3( $shortcode ) {

    $theme_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout('aira_layout3', [
        'title' => esc_html__('Aira Creative', 'aira'),
        'image' => $theme_dir . 'aira_layout3.jpg',
    ]);

    $shortcode->add_dependecy( 'aira_number', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_image', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_current', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_symbol', 'template', 'aira_layout3' );
    $shortcode->add_dependecy( 'aira_corners', 'template', 'aira_layout3');

    $shortcode->add_dependecy( 'aira_use_descr_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_descr_typo', 'aira_use_descr_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_count_title_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_count_title_typo', 'aira_use_count_title_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_current_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_current_typo', 'aira_use_current_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_number_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_number_typo', 'aira_use_number_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_symbol_typo', 'template', 'aira_layout3');
    $shortcode->add_dependecy( 'aira_symbol_typo', 'aira_use_symbol_typo', 'true' );

    aheto_demos_add_dependency( ['description','heading'], ['aira_layout3'], $shortcode );

    $shortcode->add_params( [
        'aira_use_symbol_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Symbol?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_symbol_typo' => [
            'type'     => 'typography',
            'group'    => 'Symbol Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__symbol',
        ],
        'aira_use_number_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Number?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_number_typo' => [
            'type'     => 'typography',
            'group'    => 'Number Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number',
        ],
        'aira_use_current_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Current?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_current_typo' => [
            'type'     => 'typography',
            'group'    => 'Current Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__current',
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
        'aira_use_descr_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Description?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_descr_typo' => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__desc',
        ],
        'aira_corners'       => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable styled corners?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_image'     => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Image', 'aira' ),
        ],
        'aira_current'   => [
            'type'    => 'text',
            'heading' => esc_html__( 'Symbol before Number', 'aira' ),
        ],
        'aira_number'    => [
            'type'    => 'text',
            'heading' => esc_html__( 'Number', 'aira' ),
            'default'     => esc_html__( '50', 'aira' ),
        ],
        'aira_symbol'    => [
            'type'    => 'text',
            'heading' => esc_html__( 'Symbol after Number', 'aira' ),
            'default'     => esc_html__( 'm', 'aira' ),
        ],
    ] );
}

function aira_progress_bar_layout3_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['aira_use_current_typo']) && !empty($shortcode->atts['aira_current_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__current'], $shortcode->parse_typography($shortcode->atts['aira_current_typo']));
    }
    if (!empty($shortcode->atts['aira_use_number_typo']) && !empty($shortcode->atts['aira_number_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography($shortcode->atts['aira_number_typo']));
    }
    if (!empty($shortcode->atts['aira_use_symbol_typo']) && !empty($shortcode->atts['aira_symbol_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__symbol'], $shortcode->parse_typography($shortcode->atts['aira_symbol_typo']));
    }
    if (!empty($shortcode->atts['aira_use_descr_typo']) && !empty($shortcode->atts['aira_descr_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__desc'], $shortcode->parse_typography($shortcode->atts['aira_descr_typo']));
    }
    if (!empty($shortcode->atts['aira_use_count_title_typo']) && !empty($shortcode->atts['aira_count_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['aira_count_title_typo']));
    }
    return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'aira_progress_bar_layout3_dynamic_css', 10, 2 );
