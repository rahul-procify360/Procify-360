<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'acacio_list_layout3' );

/**
 * List
 */

function acacio_list_layout3( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'acacio_layout3', [
		'title' => esc_html__( 'List 3', 'acacio' ),
		'image' => $dir . 'acacio_layout3.jpg',
	] );

    aheto_demos_add_dependency( 'lists', [ 'acacio_layout3' ], $shortcode );

    //  Acacio Ordered List
    $shortcode->add_dependecy( 'acacio_number_background', 'template', 'acacio_layout3' );
    $shortcode->add_dependecy( 'acacio_number_color', 'template', 'acacio_layout3' );

	$shortcode->add_dependecy( 'acacio_use_list_typo', 'template', 'acacio_layout3' );
	$shortcode->add_dependecy( 'acacio_list_typo', 'template', 'acacio_layout3' );
	$shortcode->add_dependecy( 'acacio_list_typo', 'acacio_use_list_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_num_typo', 'template', 'acacio_layout3' );
	$shortcode->add_dependecy( 'acacio_num_typo', 'template', 'acacio_layout3' );
	$shortcode->add_dependecy( 'acacio_num_typo', 'acacio_use_num_typo', 'true' );
	$shortcode->add_params( [

        'acacio_number_background' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color for numbers', 'acacio' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} li b' => 'background-color: {{VALUE}}' ],
        ],
        'acacio_number_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Color for numbers', 'acacio' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} li b' => 'color: {{VALUE}}' ],
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
            'selector' => '{{WRAPPER}} li, {{WRAPPER}} p',
        ],

        'acacio_use_num_typo' => [
	        'type'    => 'switch',
	        'heading' => esc_html__( 'Use custom font for numbers?', 'acacio' ),
	        'grid'    => 3,
        ],

        'acacio_num_typo' => [
	        'type'     => 'typography',
	        'group'    => 'Acacio Number Typography',
	        'settings' => [
		        'tag'        => false,
		        'text_align' => true,
	        ],
	        'selector' => '{{WRAPPER}} li b',
        ],
    ] );

}

function acacio_list_layout3_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_number_background'] ) ) {
        $color = Sanitize::color( $shortcode->atts['acacio_number_background'] );
        $css['global']['%1$s li b']['background-color'] = $color;
    }

    if ( ! empty( $shortcode->atts['acacio_number_color'] ) ) {
        $color = Sanitize::color( $shortcode->atts['acacio_number_color'] );
        $css['global']['%1$s li b']['color'] = $color;
    }

    if ( ! empty( $shortcode->atts['acacio_use_list_typo'] ) && ! empty( $shortcode->atts['acacio_list_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s li, %1$s p'], $shortcode->parse_typography( $shortcode->atts['acacio_list_typo'] ) );
    }

	if ( ! empty( $shortcode->atts['acacio_use_num_typo'] ) && ! empty( $shortcode->atts['acacio_num_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s li b'], $shortcode->parse_typography( $shortcode->atts['acacio_num_typo'] ) );
	}

    return $css;
}

add_filter( 'aheto_list_dynamic_css', 'acacio_list_layout3_dynamic_css', 10, 2 );
