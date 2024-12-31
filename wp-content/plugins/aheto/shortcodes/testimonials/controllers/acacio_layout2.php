<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'acacio_testimonials_layout2' );

/**
 * Testimonials
 */

function acacio_testimonials_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'acacio_layout2', [
		'title' => esc_html__( 'Testimonials 2', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout2.jpg',
	] );

    $shortcode->add_dependecy( 'acacio_testimonials_image', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_testimonials_name', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_testimonials_text', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_testimonials_company', 'template', 'acacio_layout2' );

    $shortcode->add_dependecy( 'acacio_use_name_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_name_typo', 'acacio_use_name_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_position_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_position_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_position_typo', 'acacio_use_position_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_descr_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_descr_typo', 'acacio_use_descr_typo', 'true' );

    $shortcode->add_params( [
        'acacio_use_name_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for name?', 'acacio' ),
            'grid'    => 3,
        ],

	    'acacio_name_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Name Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => true,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-tm__name',
	    ],
        'acacio_use_position_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for position?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_position_typo' => [
            'type'     => 'typography',
            'group'    => 'Position Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__position',
        ],
	    'acacio_use_descr_typo' => [
		    'type'    => 'switch',
		    'heading' => esc_html__( 'Use custom font for testimonials?', 'acacio' ),
		    'grid'    => 3,
	    ],

        'acacio_descr_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Testimonials Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__text',
        ],
        'acacio_testimonials_image'       => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Display Image', 'acacio' ),
        ],
        'acacio_testimonials_name'        => [
            'type'    => 'text',
            'heading' => esc_html__( 'Name', 'acacio' ),
            'default' => esc_html__( 'Author name', 'acacio' ),
        ],
        'acacio_testimonials_company'     => [
            'type'    => 'text',
            'heading' => esc_html__( 'Position', 'acacio' ),
            'default' => esc_html__( 'Author position', 'acacio' ),
        ],
        'acacio_testimonials_text' => [
            'type'    => 'textarea',
            'heading' => esc_html__( 'Testimonial', 'acacio' ),
            'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'acacio' ),
        ],
    ] );


}

function acacio_testimonials_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['acacio_use_name_typo'] ) && ! empty( $shortcode->atts['acacio_name_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography( $shortcode->atts['acacio_name_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_position_typo'] ) && ! empty( $shortcode->atts['acacio_position_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography( $shortcode->atts['acacio_position_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_descr_typo'] ) && ! empty( $shortcode->atts['acacio_descr_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography( $shortcode->atts['acacio_descr_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'acacio_testimonials_layout2_dynamic_css', 10, 2 );