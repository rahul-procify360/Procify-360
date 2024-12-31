<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'rela_navbar_layout1');


/**
 * Navbar Shortcode
 */
function rela_navbar_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/navbar/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Navbar 15', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_search', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_max_width', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_search_size', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_labels_icon_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_labels_icon_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_labels_icon_typo', 'rela_use_labels_icon_typo', 'true');

    aheto_demos_add_dependency(['remove_borders', 'columns', 'right_hide_mobile', 'right_links', 'left_links', 'left_hide_mobile', 'use_links_typo', 'links_typo', 'use_socials_typo', 'socials_typo'], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_use_labels_icon_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for labels icon?', 'rela'),
            'grid' => 3,
        ],
        'rela_labels_icon_typo' => [
            'type' => 'typography',
            'group' => 'Rela Labels Icon Typography',
            'settings' => [
                'text_align' => false,
                'tag' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-navbar--item-label i',
        ],
        'rela_search_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Search icon size', 'rela'),
            'description' => esc_html__( 'Enter search icon font size with units.', 'rela' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-navbar--search' => 'font-size: {{VALUE}}'],
        ],
        'rela_search' => [
            'type' => 'switch',
            'heading' => esc_html__('Searchbox', 'rela'),
        ],
        'rela_max_width' => [
            'type' => 'slider',
            'heading' => esc_html__('Max width for navbar', 'rela'),
            'grid' => 12,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 3000,
                    'step' => 5,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .aheto-navbar--wrap' => 'max-width: {{SIZE}}{{UNIT}};',
            ],
        ],
    ]);
}

function rela_navbar_layout1_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['rela_use_labels_icon_typo']) && !empty($shortcode->atts['rela_labels_icon_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-navbar--item-label i'], $shortcode->parse_typography($shortcode->atts['rela_labels_icon_typo']));
    }
    if (!empty($shortcode->atts['rela_max_width'])) {
        $css['global']['%1$s .aheto-navbar--wrap']['max-width'] = Sanitize::size($shortcode->atts['rela_max_width']);
    }
    if ( !empty($shortcode->atts['rela_search_size']) ) {
        $css['global']['%1$s .aheto-navbar--search']['font-size'] = Sanitize::size( $shortcode->atts['rela_search_size'] );
    }

    return $css;
}

add_filter('aheto_navbar_dynamic_css', 'rela_navbar_layout1_dynamic_css', 10, 2);