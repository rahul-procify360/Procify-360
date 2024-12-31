<?php

/**
 * The Banner-slider Shortcode.
 */

use Aheto\Helper;
use Aheto\Sanitize;


add_action('aheto_before_aheto_banner-slider_register', 'karma_travel_banner_slider_layout1');


function karma_travel_banner_slider_layout1($shortcode){

    $preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout('karma_travel_layout1', [
        'title' => esc_html__('Banner Slider 13', 'aheto'),
        'image' => $preview_dir . 'karma_travel_layout1.jpg',
    ]);


    $shortcode->add_dependecy('karma_travel_banner', 'template', 'karma_travel_layout1');

	$shortcode->add_dependecy('karma_travel_use_title_typo', 'template', ['karma_travel_layout1']);
	$shortcode->add_dependecy('karma_travel_title_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_title_typo', 'karma_travel_use_title_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_subtitle_typo', 'template', ['karma_travel_layout1']);
	$shortcode->add_dependecy('karma_travel_subtitle_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_subtitle_typo', 'karma_travel_use_subtitle_typo', 'true');

	$shortcode->add_dependecy('karma_travel_use_label_typo', 'template', ['karma_travel_layout1']);
	$shortcode->add_dependecy('karma_travel_label_typo', 'template', 'karma_travel_layout1');
	$shortcode->add_dependecy('karma_travel_label_typo', 'karma_travel_use_label_typo', 'true');

	$shortcode->add_params([

        'karma_travel_banner' => [
            'type' => 'group',
            'heading' => esc_html__('Banners', 'aheto'),
            'params' => [
                'karma_travel_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Background Image', 'aheto'),
                ],
                'karma_travel_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Title', 'aheto'),
                ],
                'karma_travel_subtitle' => [
                    'type' => 'text',
                    'heading' => esc_html__('Subtitle', 'aheto'),
                ],
                'karma_travel_label' => [
                    'type' => 'text',
                    'heading' => esc_html__('Label', 'aheto'),
                ],
				'karma_travel_label_color1' => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Label background color 1', 'aheto' ),
					'default'   => '#eeeeee',
				],
				'karma_travel_label_color2' => [
					'type'      => 'colorpicker',
					'heading'   => esc_html__( 'Label background color 2', 'aheto' ),
					'default'   => '#eeeeee',
				],
            ]
        ],
		'karma_travel_use_title_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for title?', 'aheto'),
			'grid'    => 3,
		],
		'karma_travel_title_typo'             => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__title',
		],
		'karma_travel_use_subtitle_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for subtitle?', 'aheto'),
			'grid'    => 3,
		],
		'karma_travel_subtitle_typo'             => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__subtitle',
		],
		'karma_travel_use_label_typo'         => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for label?', 'aheto'),
			'grid'    => 3,
		],
		'karma_travel_label_typo'             => [
			'type'     => 'typography',
			'group'    => 'Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner-slider__label',
		],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'add_button' => true,
        'prefix' => 'karma_travel_main_',
    ], 'karma_travel_banner');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'karma_travel_',
        'include' => ['effect', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
        'dependency' => ['template', ['karma_travel_layout1']]
    ]);

}

function karma_travel_banner_slider_layout1_dynamic_css($css, $shortcode){
	if ( isset($shortcode->atts['karma_travel_use_title_typo']) && $shortcode->atts['karma_travel_use_title_typo'] && isset($shortcode->atts['karma_travel_title_typo']) && !empty($shortcode->atts['karma_travel_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-banner-slider__title'], $shortcode->parse_typography($shortcode->atts['karma_travel_title_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_subtitle_typo']) && $shortcode->atts['karma_travel_use_subtitle_typo'] && isset($shortcode->atts['karma_travel_subtitle_typo']) && !empty($shortcode->atts['karma_travel_subtitle_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-banner-slider__subtitle'], $shortcode->parse_typography($shortcode->atts['karma_travel_subtitle_typo']));
	}
	if ( isset($shortcode->atts['karma_travel_use_label_typo']) && $shortcode->atts['karma_travel_use_label_typo'] && isset($shortcode->atts['karma_travel_label_typo']) && !empty($shortcode->atts['karma_travel_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s  .aheto-banner-slider__label'], $shortcode->parse_typography($shortcode->atts['karma_travel_label_typo']));
	}

    return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'karma_travel_banner_slider_layout1_dynamic_css', 10, 2);