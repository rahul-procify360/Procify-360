<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'acacio_list_layout1' );

/**
 * List
 */

function acacio_list_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'List 1', 'acacio' ),
		'image' => $dir . 'acacio_layout4.jpg',
	] );

    //  Acacio List
    $shortcode->add_dependecy( 'acacio_lists', 'template', 'acacio_layout1' );

    $shortcode->add_dependecy( 'acacio_use_list_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_list_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_list_typo', 'acacio_use_list_typo', 'true' );
    $shortcode->add_dependecy( 'acacio_links_color', 'template', 'acacio_layout1' );
    

    $shortcode->add_params( [
        'acacio_lists' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Link Lists', 'acacio' ),
            'params'  => [
                'acacio_link_text' => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Text', 'acacio' ),
                ],
                'acacio_link_url'  => [
                    'type'        => 'link',
                    'heading'     => esc_html__( 'Link', 'acacio' ),
                    'description' => esc_html__( 'Add url to list.', 'acacio' ),
                    'default'     => [
                        'url' => '#',
                    ],
                ]
            ],
        ],

        'acacio_links_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Links color', 'acacio' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-list--acacio-links li a' => 'color: {{VALUE}}' ],
        ],
        'acacio_use_list_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for list?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_list_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio List Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} li, {{WRAPPER}} p, {{WRAPPER}} li a',
        ],
    ] );

}

function acacio_list_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_links_color'] ) ) {
        $color = Sanitize::color( $shortcode->atts['color'] );
        $css['global']['%1$s .aheto-list--acacio-links li a']['color'] = $color;
    }

    if ( ! empty( $shortcode->atts['acacio_use_list_typo'] ) && ! empty( $shortcode->atts['acacio_list_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s li'], $shortcode->parse_typography( $shortcode->atts['acacio_list_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_list_dynamic_css', 'acacio_list_layout1_dynamic_css', 10, 2 );