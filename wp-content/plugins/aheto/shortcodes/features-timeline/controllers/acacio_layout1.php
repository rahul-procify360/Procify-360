<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-timeline_register', 'acacio_features_timeline_layout1' );


/**
 * Features Timeline Shortcode
 */

function acacio_features_timeline_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/features-timeline/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Features Timeline 1', 'acacio' ),
		'image' => $dir . 'acacio_layout1.jpg',
	] );

    $shortcode->add_dependecy( 'acacio_timeline', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_dark_version', 'template', 'acacio_layout1' );

    $shortcode->add_dependecy( 'acacio_use_title_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'acacio_use_title_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_descr_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_descr_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_descr_typo', 'acacio_use_descr_typo', 'true' );

    $shortcode->add_params( [
        'acacio_timeline' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Items', 'acacio' ),
            'params'  => [
                'acacio_timeline_date'       => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Date', 'acacio' ),
                ],
                'acacio_timeline_title'        => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Title', 'acacio' ),
                    'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'acacio' ),
                    'default'     => esc_html__( 'Title with [[ hightlight ]] text.', 'acacio' ),
                ],
                'acacio_timeline_content'        => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Content', 'acacio' ),
                    'default' => esc_html__( 'Add some text for content', 'acacio' ),
                ],
                'acacio_timeline_image'     => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Add image', 'acacio'),
                ],
            ],
        ],

        'acacio_dark_version'    => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable dark version?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for timeline content title?', 'acacio' ),
            'grid'    => 3,
        ],


        'acacio_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Timeline Title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-timeline__title',
        ],
        'acacio_use_descr_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for timeline content description?', 'acacio' ),
            'grid'    => 3,
        ],


        'acacio_descr_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Timeline Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-timeline__desc',
        ],


    ] );

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'acacio_',
        'icons'      => true,
    ], 'acacio_timeline');

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for timeline image ', 'acacio' ),
        'prefix'     => 'acacio_time_',
        'dependency' => ['template', [ 'acacio_layout1'] ]
    ]);
}

function acacio_features_timeline_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['acacio_use_title_typo'] ) && ! empty( $shortcode->atts['acacio_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-timeline__title'], $shortcode->parse_typography( $shortcode->atts['acacio_title_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['acacio_use_descr_typo'] ) && ! empty( $shortcode->atts['acacio_descr_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-timeline__desc'], $shortcode->parse_typography( $shortcode->atts['acacio_descr_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_fetaures_timeline_dynamic_css', 'acacio_features_timeline_layout1_dynamic_css', 10, 2 );
