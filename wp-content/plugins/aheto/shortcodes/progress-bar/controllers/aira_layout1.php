<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_progress-bar_register', 'aira_progress_bar_layout1' );



/**
 * Progress Bar Shortcode
 */

function aira_progress_bar_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/progress-bar/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Modern', 'aira' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_number', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_image', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_current', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_symbol', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_description', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_corners', 'template', 'aira_layout1');

    $shortcode->add_dependecy( 'aira_use_descr_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_descr_typo', 'aira_use_descr_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_highlight_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_highlight_typo', 'aira_use_highlight_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_current_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_current_typo', 'aira_use_current_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_number_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_number_typo', 'aira_use_number_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_symbol_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_symbol_typo', 'aira_use_symbol_typo', 'true' );


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
        'aira_description' => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Description', 'aira' ),
            'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]].', 'aira' ),
            'default'     => esc_html__( 'Description with [[ hightlight ]] text.', 'aira' ),
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
        'aira_use_highlight_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Highlight text?', 'aira' ),
            'grid'    => 6,
        ],
        'aira_highlight_typo' => [
            'type'     => 'typography',
            'group'    => 'Highlight text Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__desc span',
        ],
    ] );


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'aira_',
        'dependency' => ['template', ['aira_layout1']]
    ]);

}









function aira_progress_bar_layout1_dynamic_css($css, $shortcode)
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
    if (!empty($shortcode->atts['aira_use_highlight_typo']) && !empty($shortcode->atts['aira_highlight_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__desc span'], $shortcode->parse_typography($shortcode->atts['aira_highlight_typo']));
    }
    return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'aira_progress_bar_layout1_dynamic_css', 10, 2 );
