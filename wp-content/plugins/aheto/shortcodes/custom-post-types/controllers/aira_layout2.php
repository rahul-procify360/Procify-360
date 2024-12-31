<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_custom-post-types_register', 'aira_custom_post_types_layout2' );


/**
 * Custom post type style for blog items
 */
function aira_custom_post_types_layout2($shortcode) {

    $theme_dir = '//assets.aheto.co/custom-post-types/previews/';

    $shortcode->add_layout( 'aira_layout2', [
        'title' => esc_html__( 'Aira Grid', 'aira' ),
        'image' => $theme_dir . 'aira_layout2.jpg',
    ] );

    aheto_demos_add_dependency( [
        'skin',
        't_heading',
        'use_heading',
        'image_height',
        'title_tag',
        'use_term',
        't_term',
        'add_center_filter',
        'all_items_text',
        'add_filter',
        'add_pagination',
        'spaces',
        'item_per_row',
        'spaces_lg',
        'item_per_row_lg',
        'spaces_md',
        'item_per_row_md',
        'spaces_sm',
        'item_per_row_sm',
        'spaces_xs',
        'item_per_row_xs'
    ], [ 'aira_layout2' ], $shortcode );

    $shortcode->add_dependecy('aira_pagination_space', 'template', 'aira_layout2' );

    $shortcode->add_params([
        'aira_pagination_space'    => [
            'type'      => 'responsive_spacing',
            'heading'   => esc_html__( 'Margin spaces for pagination', 'aira' ),
            'grid'      => 12,
            'selectors' => [
                '{{WRAPPER}} .aheto-cpt-pagination' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ],
    ]);
}

function aira_cpt_layout2_dynamic_css( $css, $shortcode ) {

    if ( !empty($shortcode->atts['aira_pagination_space']) ) {
        $selector                   = '%1$s .aheto-cpt-pagination';
        $shortcode->atts['aira_pagination_space'] = Sanitize::responsive_spacing($shortcode->atts['aira_pagination_space'], 'margin');

        if ( !empty($shortcode->atts['aira_pagination_space']['desktop']) ) {
            \aheto_add_props($css['global'][$selector], $shortcode->atts['aira_pagination_space']['desktop']);
        }
        if ( !empty($shortcode->atts['aira_pagination_space']['laptop']) ) {
            \aheto_add_props($css['@media (max-width: 1199px)'][$selector], $shortcode->atts['aira_pagination_space']['laptop']);
        }
        if ( !empty($shortcode->atts['aira_pagination_space']['tablet']) ) {
            \aheto_add_props($css['@media (max-width: 991px)'][$selector], $shortcode->atts['aira_pagination_space']['tablet']);
        }
        if ( !empty($shortcode->atts['aira_pagination_space']['mobile']) ) {
            \aheto_add_props($css['@media (max-width: 767px)'][$selector], $shortcode->atts['aira_pagination_space']['mobile']);
        }
    }
    return $css;
}
add_filter( 'aheto_cpt_dynamic_css', 'aira_cpt_layout2_dynamic_css', 10, 2 );