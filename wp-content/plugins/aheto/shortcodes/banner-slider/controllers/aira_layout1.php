<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_banner-slider_register', 'aira_banner_slider_layout1' );

/**
 * Banner Slider
 */
function aira_banner_slider_layout1( $shortcode ) {

    $theme_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Banner Slider 3', 'aheto' ),
        'image' => $theme_dir . 'aira_layout1.jpg',
    ] );


    $shortcode->add_dependecy( 'aira_modern_banners', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_arrrows_position', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_dark_arrows', 'template', 'aira_layout1' );

    $shortcode->add_dependecy( 'aira_use_description_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_description_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_description_typo', 'aira_use_description_typo', 'true' );

    $shortcode->add_dependecy( 'aira_use_hightlight_typo', 'template', 'aira_layout1');
    $shortcode->add_dependecy( 'aira_hightlight_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_hightlight_typo', 'aira_use_hightlight_typo', 'true' );

    aheto_demos_add_dependency(['use_heading', 't_heading'], ['aira_layout1'], $shortcode);

    $shortcode->add_params( [
	    'aira_modern_banners' => [
		    'type'    => 'group',
		    'heading' => esc_html__( 'Banners', 'aheto' ),
		    'params'  => [
			    'aira_image'         => [
				    'type'    => 'attach_image',
				    'heading' => esc_html__( 'Background Image', 'aheto' ),
			    ],
			    'aira_add_image'     => [
				    'type'    => 'attach_image',
				    'heading' => esc_html__( 'Additional Image', 'aheto' ),
			    ],
			    'aira_title'         => [
				    'type'    => 'text',
				    'heading' => esc_html__( 'Title', 'aheto' ),
				    'default'    => 'Slide title with [[highlight text]]',
				    'description' => esc_html__( 'To highlight text insert text between: [[ Your Text Here ]].', 'aheto' ),
			    ],
			    'aira_desc'          => [
				    'type'    => 'textarea',
				    'heading' => esc_html__( 'Description', 'aheto' ),
				    'default'    => 'Slide description',
			    ],
			    'aira_btn_direction' => [
				    'type'    => 'select',
				    'heading' => esc_html__( 'Buttons Direction', 'aheto' ),
				    'options' => [
					    ''            => esc_html__( 'Horizontal', 'aheto' ),
					    'is-vertical' => esc_html__( 'Vertical', 'aheto' ),
				    ],
			    ],
			    'aira_overlay-color' => [
				    'type'      => 'colorpicker',
				    'heading'   => esc_html__('Overlay color', 'aheto' ),
				    'grid'      => 6,
				    'selectors' => ['{{WRAPPER}} .swiper-slide-overlay' => 'background-color: {{VALUE}}']
			    ],
		    ]
	    ],
        'aira_use_description_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'aheto' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_description_typo' => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
        ],

        'aira_use_hightlight_typo'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for highlight?', 'aheto' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_hightlight_typo' => [
            'type'     => 'typography',
            'group'    => 'Highlight Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner__title span',
        ],

        'aira_arrrows_position'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Move navigation arrows to the left?', 'aheto' ),
            'grid'    => 12,
            'default' => '',
        ],
        'aira_dark_arrows'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use dark theme for navigation arrows?', 'aheto' ),
            'grid'    => 12,
            'default' => '',
        ],

    ] );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_button' => true,
        'prefix' => 'aira_main_',
    ], 'aira_modern_banners' );

    \Aheto\Params::add_button_params( $shortcode, [
        'add_button' => true,
        'prefix'    => 'aira_add_',
        'add_label' => esc_html__( 'Add additional button?', 'aheto' ),
    ], 'aira_modern_banners' );

    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'aira_swiper_',
        'include'        => [ 'effect', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'arrows_size'],
        'dependency'     => [ 'template', [ 'aira_layout1' ] ]
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'aira_add_',
        'group' => 'Additional Image size',
        'dependency' => ['template', ['aira_layout1']]
    ]);
}

function aira_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_description_typo'] ) && ! empty( $shortcode->atts['aira_description_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography( $shortcode->atts['aira_description_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['aira_use_hightlight_typo'] ) && ! empty( $shortcode->atts['aira_hightlight_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-banner__title span'], $shortcode->parse_typography( $shortcode->atts['aira_hightlight_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['aira_overlay-color'] ) ) {
        $color  = Sanitize::color( $shortcode->atts['aira_overlay-color'] );
        $css['global']['%1$s .swiper-slide-overlay']['background-color'] = $color;
    }

    if ( !empty($shortcode->atts['aira_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['aira_arrows_size'] );
    }
    return $css;
}

add_filter( 'aheto_banner_slider_dynamic_css', 'aira_banner_slider_layout1_dynamic_css', 10, 2 );
