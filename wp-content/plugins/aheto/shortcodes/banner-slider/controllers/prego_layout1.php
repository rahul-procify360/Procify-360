<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'prego_banner_slider_layout1');

/**
 * Banner Slider Shortcode
 */

function prego_banner_slider_layout1($shortcode) {

    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout( 'prego_layout1', [
		'title' => esc_html__( 'Prego Banner Slider', 'prego' ),
		'image' => $preview_dir . 'prego_layout1.jpg',
	] );

	$shortcode->add_dependecy('prego_main_subtitle', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_main_title', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_images', 'template', 'prego_layout1');

	$shortcode->add_dependecy('prego_use_sub_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_sub_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_sub_typo', 'prego_use_sub_typo', 'true');
	$shortcode->add_dependecy('prego_use_title_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_title_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_title_typo', 'prego_use_title_typo', 'true');
    $shortcode->add_dependecy('prego_use_arrows_text_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_arrows_text_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_arrows_text_typo', 'prego_use_arrows_text_typo', 'true');
    $shortcode->add_dependecy('prego_use_pag_text_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_pag_text_typo', 'template', 'prego_layout1');
	$shortcode->add_dependecy('prego_pag_text_typo', 'prego_use_pag_text_typo', 'true');

    $shortcode->add_params( [

        'prego_main_subtitle'          => [
            'type'    => 'text',
            'heading' => esc_html__( 'Subtitle', 'prego' ),
            'admin_label' => true,
        ],
        'prego_main_title'         => [
            'type'    => 'text',
            'heading' => esc_html__( 'Title', 'prego' ),
            'admin_label' => true,
        ],
        'prego_images'         => [
            'type'    => 'attach_images',
            'heading' => esc_html__( 'Images', 'prego' ),
        ],

		'prego_use_sub_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for subtitle?', 'prego' ),
			'grid'    => 3,
		],
		'prego_sub_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
                'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__subtitle',
		],
		'prego_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'prego' ),
			'grid'    => 3,
		],
		'prego_title_typo' => [
			'type'     => 'typography',
	        'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
                'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__title',
		],
        'prego_use_pag_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for pagination?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_pag_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Pagination Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .swiper-pagination-bullet',
        ],
        'prego_use_arrows_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for arrows?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_arrows_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Arrows Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .swiper-buttons span',
        ],
	] );


    \Aheto\Params::add_button_params( $shortcode, [
        'add_button' => true,
        'prefix' => 'prego_',
    ], '' );

    \Aheto\Params::add_carousel_params($shortcode, [
        'group'          => 'Prego Swiper',
        'custom_options' => true,
        'prefix'         => 'prego_swiper_',
        'include'        => [
            'pagination',
            'arrows',
            'autoplay',
            'speed',
            'simulate_touch',
        ], 'dependency'  => ['template', ['prego_layout1']]
    ]);

}
