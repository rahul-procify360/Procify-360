<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'kunst_banner_slider_layout1' );

/**
 * Kunst Banner Slider
 */

function kunst_banner_slider_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout( 'kunst_layout1', [
        'title' => esc_html__( 'Kunst Creative', 'kunst' ),
        'image' => $preview_dir . 'kunst_layout1.jpg',
	]);

	$shortcode->add_dependecy( 'kunst_height_size', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_height', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_reverse', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_banner_line_decoration', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_creative_banners', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_button_align', 'kunst_creative_main_add_button', 'true' );

	$shortcode->add_dependecy( 'kunst_use_banner_text_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_banner_text_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_banner_text_typo', 'kunst_use_banner_text_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_pag_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_pag_text_typo', 'template', [ 'kunst_layout1' ] );
	$shortcode->add_dependecy( 'kunst_pag_text_typo', 'kunst_use_pag_typo', 'true' );

    $shortcode->add_params( [

		'kunst_height_size' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Use Height Size for Banner', 'kunst' ),
            'options' => [
                'px'  => 'px',
                'vh'  => 'vh',
                'vw'  => 'vw',
            ],
            'default' => 'px'
        ],
		'kunst_height' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Use Height for Banner', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_reverse' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use reverse for Banner Option?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_banner_line_decoration' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use Line Decoration for Banner?', 'kunst' ),
			'grid'    => 3,
		],
        'kunst_creative_banners' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Kunst Banners Creative', 'kunst' ),
            'params'  => [
                'kunst_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'kunst' ),
				],
				'kunst_add_image'     => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Additional Image', 'kunst' ),
				],
				'kunst_align_add_image' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Additional Image Align', 'kunst' ),
					'options' => [
						'default' => 'Default',
						'left'    => 'Left',
						'center'  => 'Center',
						'right'   => 'Right',
					],
					'default' => 'default',
				],
				'kunst_banner_text'     => [
                    'type'        => 'textarea',
                    'heading'     => esc_html__( 'Banner Text', 'kunst' ),
                    'admin_label' => true,
                    'default'     => esc_html__( 'Banner Text.', 'kunst' ),
                ],
                'kunst_button_align'     => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Align for Button', 'kunst' ),
                    'options' => \Aheto\Helper::choices_alignment(),
                    'default' => 'default',
                ]
            ]
		],

		'kunst_use_banner_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for banner text?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_banner_text_typo'        => [
			'type'     => 'typography',
			'group'    => 'Banner Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__text',
		],

		'kunst_use_pag_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Pagination text?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_pag_text_typo'        => [
			'type'     => 'typography',
			'group'    => 'Pagination Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
		]

    ]);

    \Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'kunst_creative_main_',
	], 'kunst_creative_banners' );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'kunst_swiper_',
        'include'        => [ 'effect', 'pagination', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'arrows_num_typo', 'arrows_style', 'arrows_color', 'arrows_size' ],
        'dependency'     => [ 'template', [ 'kunst_layout1' ] ]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'kunst_',
        'dependency' => [ 'template', [ 'kunst_layout1' ] ]
    ]);

}

function kunst_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_banner_text_typo']) && !empty($shortcode->atts['kunst_banner_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner-slider__text'], $shortcode->parse_typography($shortcode->atts['kunst_banner_text_typo']));
	}

	if ( !empty($shortcode->atts['kunst_use_pag_typo']) && !empty($shortcode->atts['kunst_pag_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .swiper-pagination-bullet'], $shortcode->parse_typography($shortcode->atts['kunst_pag_text_typo']));
	}

	if ( !empty($shortcode->atts['kunst_swiper_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['kunst_swiper_arrows_color']);
    }

    if ( !empty($shortcode->atts['kunst_swiper_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['kunst_swiper_arrows_size'] );
    }

    if ( ! empty($shortcode->atts['kunst_swiper_arrows_num_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .swiper-button-next span, %1$s .swiper-button-prev span'], $shortcode->parse_typography( $shortcode->atts['kunst_swiper_arrows_num_typo'] ) );
    }

	return $css;

}

add_filter( 'aheto_banner_slider_dynamic_css', 'kunst_banner_slider_layout1_dynamic_css', 10, 2 );
