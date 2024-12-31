<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'acacio_banner_slider_layout1' );

/**
 *  Banner Slider
 */

function acacio_banner_slider_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout( 'acacio_layout1', [
        'title' => esc_html__( 'Banner Slider 2', 'aheto' ),
        'image' => $preview_dir . 'acacio_layout1.jpg',
    ] );

	aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'acacio_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_hide_pagination', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_modern_banners', 'template', 'acacio_layout1' );

    $shortcode->add_dependecy( 'acacio_use_hightlight_typo', 'template', 'acacio_layout1' );

    $shortcode->add_dependecy( 'acacio_hightlight_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_hightlight_typo', 'acacio_use_hightlight_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_bullets_color', 'template', 'acacio_layout1' );

    $shortcode->add_dependecy( 'acacio_bullet_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_bullet_color', 'acacio_use_bullets_color', 'true' );

    $shortcode->add_dependecy( 'acacio_bullet_color_active', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_bullet_color_active', 'acacio_use_bullets_color', 'true' );

    $shortcode->add_params( [
        'acacio_modern_banners' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Banners', 'aheto' ),
            'params'  => [
                'acacio_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Background Image', 'aheto' ),
                ],
                'acacio_heading_tag'      => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Element tag for title', 'aheto' ),
                    'options' => [
                        'h1'  => 'h1',
                        'h2'  => 'h2',
                        'h3'  => 'h3',
                        'h4'  => 'h4',
                        'h5'  => 'h5',
                        'h6'  => 'h6',
                        'p'   => 'p',
                        'div' => 'div',
                    ],
                    'default' => 'h2',
                ],
                'acacio_title'         => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Title', 'aheto' ),
                    'description' => esc_html__( 'To Highlight text insert text between: [[ Your Text Here ]]', 'aheto' ),
                    'admin_label' => true,
                    'default'     => esc_html__( 'Heading with [[ highlight ]] text. For set some words for repeat animation separate them by coma : [[London,New York,Paris]]', 'aheto' ),
                ],
                'acacio_desc'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Description', 'aheto' ),
                ],
                'align' => [
                    'type'    => 'select',
                    'heading' => esc_html__('Align', 'aheto'),
                    'options' => \Aheto\Helper::choices_alignment(),
                ],
                'acacio_btn_direction' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Buttons Direction', 'aheto' ),
                    'options' => [
                        ''            => esc_html__( 'Horizontal', 'aheto' ),
                        'is-vertical' => esc_html__( 'Vertical', 'aheto' ),
                    ],
                ],

            ]
        ],
        'acacio_use_hightlight_typo'   => [
	        'type'    => 'switch',
	        'heading' => esc_html__( 'Use custom font for highlight?', 'aheto' ),
	        'grid'    => 12,
	        'default' => '',
        ],
        'acacio_hightlight_typo' => [
	        'type'     => 'typography',
	        'group'    => 'Highlight Typography',
	        'settings' => [
		        'text_align' => false,
	        ],
	        'selector' => '{{WRAPPER}} .aheto-banner__title span',
        ],
        'acacio_use_bullets_color'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Add your colors for slider bullets?', 'aheto'),
            'grid'      => 4,
        ],
        'acacio_bullet_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Slider bullet color', 'aheto' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet' => 'background: {{VALUE}}' ],
        ],
        'acacio_bullet_color_active' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Slider bullet active color', 'aheto' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background: {{VALUE}}' ],
        ],

    ] );


    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'acacio_swiper_banner_',
        'include'        => [ 'effect', 'speed', 'loop', 'slides', 'autoplay','lazy', 'arrows', 'pagination', 'simulate_touch' ],
        'dependency'     => [ 'template', [ 'acacio_layout1' ] ]
    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'prefix' => 'acacio_main_',
    ], 'acacio_modern_banners' );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_label' => esc_html__( 'Add additional button?', 'aheto' ),
        'prefix'    => 'acacio_add_',
    ], 'acacio_modern_banners' );

}


function acacio_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

    if ( $shortcode->atts['acacio_use_bullet_color'] && ! empty( $shortcode->atts['acacio_bullet_color'] )  ) {
        $css['global']['%1$s .swiper-pagination-bullet']['background'] = \Aheto\Sanitize::color( $shortcode->atts['acacio_bullet_color'] );
    }

    if (! empty( $shortcode->atts['acacio_bullet_color_active'] )  ) {
        $css['global']['%1$s .swiper-pagination-bullet-active']['background'] = \Aheto\Sanitize::color( $shortcode->atts['acacio_bullet_color_active'] );
    }


	if ( ! empty( $shortcode->atts['acacio_use_hightlight_typo'] ) && ! empty( $shortcode->atts['acacio_hightlight_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-banner__title span'], $shortcode->parse_typography( $shortcode->atts['acacio_hightlight_typo'] ) );
	}

    return $css;
}

add_filter( 'aheto_banner-slider_dynamic_css', 'acacio_banner_slider_layout1_dynamic_css', 10, 2 );
