<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_banner-slider_register', 'moovit_banner_slider_layout1' );

/**
 *  Banner Slider
 */

function moovit_banner_slider_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Banner Slider 16', 'aheto' ),
		'image' => $preview_dir . 'moovit_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'moovit_modern_banners', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_arrows', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_use_description_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_description_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_description_typo', 'moovit_use_description_typo', 'true' );

	aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_params( [
		'moovit_modern_banners' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Banners', 'aheto' ),
			'params'  => [
				'moovit_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background Image', 'aheto' ),
				],
				'moovit_add_image'     => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Additional Image', 'aheto' ),
				],
				'moovit_title'         => [
					'type'    => 'text',
					'heading' => esc_html__( 'Title', 'aheto' ),
				],
                'moovit_title_tag'       => [
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
                    'default' => 'h1',
                ],
				'moovit_desc'          => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Description', 'aheto' ),
				],
                'align'            => true,
				'moovit_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__( 'Buttons Direction', 'aheto' ),
					'options' => [
						''            => esc_html__( 'Horizontal', 'aheto' ),
						'is-vertical' => esc_html__( 'Vertical', 'aheto' ),
					],
				],
			]
		],
        'moovit_arrows' => [
            'type'    => 'select',
            'group'    => 'Slider Options',
            'heading' => esc_html__( 'Style for arrows', 'aheto' ),
            'grid'    => 6,
            'options' => [
                'bottom_modern' => esc_html__('Bottom modern', 'aheto'),
                'middle_modern' => esc_html__('Middle modern', 'aheto'),
            ],
            'default' => 'bottom_modern',
        ],

		'moovit_use_description_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for description?', 'aheto' ),
			'grid'    => 3,
		],

		'moovit_description_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
		],

	] );

	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'moovit_main_',
	], 'moovit_modern_banners' );

	\Aheto\Params::add_button_params( $shortcode, [
		'add_label' => esc_html__( 'Add additional button?', 'aheto' ),
		'prefix'    => 'moovit_add_',
	], 'moovit_modern_banners' );

	\Aheto\Params::add_carousel_params( $shortcode, [
		'custom_options' => true,
		'prefix'         => 'moovit_swiper_',
		'include'        => [ 'effect', 'pagination', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch',  'arrows_color', 'arrows_hover_color','arrows_size' ],
		'dependency'     => [ 'template', [ 'moovit_layout1' ] ]
	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Additional image size', 'aheto' ),
		'prefix'     => 'moovit_',
		'dependency' => ['template', ['moovit_layout1']]
	]);

}



function moovit_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_description_typo'] ) && ! empty( $shortcode->atts['moovit_description_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography( $shortcode->atts['moovit_description_typo'] ) );
	}

	if ( !empty($shortcode->atts['moovit_swiper_arrows_color']) ) {
		$css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['moovit_swiper_arrows_color']);
	}

	if ( !empty($shortcode->atts['moovit_swiper_arrows_size']) ) {
		$css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['moovit_swiper_arrows_size'] );
	}

	return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'moovit_banner_slider_layout1_dynamic_css', 10, 2 );