<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_list_register', 'acacio_list_layout2' );

/**
 * List
 */

function acacio_list_layout2( $shortcode ) {
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout( 'acacio_layout2', [
		'title' => esc_html__( 'List 2', 'acacio' ),
		'image' => $dir . 'acacio_layout2.jpg',
	] );

// Acacio Table List
    $shortcode->add_dependecy( 'acacio_first_column', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_second_column', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_third_column', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_table_lists', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_background', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_use_position_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_position_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_position_typo', 'acacio_use_position_typo', 'true' );
	$shortcode->add_dependecy( 'acacio_use_list_column_typo', 'template', 'acacio_layout2' );
	$shortcode->add_dependecy( 'acacio_list-column_typo', 'template', 'acacio_layout2' );
	$shortcode->add_dependecy( 'acacio_list-column_typo', 'acacio_use_list_column_typo', 'true' );

    $shortcode->add_params( [
        'acacio_first_column'  => [
            'type'    => 'text',
            'heading' => esc_html__( 'First Column Title', 'acacio' ),
        ],
        'acacio_second_column' => [
            'type'    => 'text',
            'heading' => esc_html__( 'Second Column Title', 'acacio' ),
        ],
        'acacio_third_column'  => [
            'type'    => 'text',
            'heading' => esc_html__( 'Third Column Title', 'acacio' ),
        ],
        'acacio_table_lists'   => [
            'type'    => 'group',
            'heading' => esc_html__( 'Table Lists', 'acacio' ),
            'params'  => [
                'acacio_first_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'First Item Text', 'acacio' ),
                ],
                'acacio_second_item' => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Second Item Text', 'acacio' ),
                ],
                'acacio_third_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Third Item Text', 'acacio' ),
                ],
            ],
        ],
        'acacio_background' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Background color', 'acacio' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-list--row .aheto-list--column' => 'background: {{VALUE}}' ],
        ],
        'acacio_use_position_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for position?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_position_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Position Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-list--column h5',
        ],
	    'acacio_use_list_column_typo' => [
		    'type'    => 'switch',
		    'heading' => esc_html__( 'Use custom font for location and type?', 'acacio' ),
		    'grid'    => 3,
	    ],

	    'acacio_list_column_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Location And Type Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-list--column ',
	    ],
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
    ], 'acacio_table_lists' );

}

function acacio_list_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_list_column_typo'] ) && ! empty( $shortcode->atts['acacio_list_column_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-list--column h5'], $shortcode->parse_typography( $shortcode->atts['acacio_list_column_typo'] ) );
    }
	if ( ! empty( $shortcode->atts['acacio_use_position_typo'] ) && ! empty( $shortcode->atts['acacio_position_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-list--column'], $shortcode->parse_typography( $shortcode->atts['acacio_position_typo'] ) );
	}
    if ( ! empty( $shortcode->atts['acacio_use_list_typo'] ) && ! empty( $shortcode->atts['acacio_list_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s li'], $shortcode->parse_typography( $shortcode->atts['acacio_list_typo'] ) );
    }
    return $css;
}

add_filter( 'aheto_list_dynamic_css', 'acacio_list_layout2_dynamic_css', 10, 2 );