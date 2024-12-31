<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'pointe_banner_slider_layout1');

/**
 *  Banner Slider
 */

function pointe_banner_slider_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout('pointe_layout1', [
		'title' => esc_html__('Banner Slider 21', 'pointe'),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	]);

	$shortcode->add_dependecy('pointe_modern_banners', 'template', 'pointe_layout1');

    $shortcode->add_dependecy('pointe_use_subtitle_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_subtitle_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_subtitle_typo', 'pointe_use_subtitle_typo', 'true');
    
    $shortcode->add_dependecy('pointe_use_arrows_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_arrows_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_arrows_typo', 'pointe_use_arrows_typo', 'true');

	aheto_demos_add_dependency(['use_heading', 't_heading'], ['pointe_layout1'], $shortcode);

	$shortcode->add_params([
		'pointe_modern_banners' => [

            'type'    => 'group',
            'heading' => esc_html__('Pointe 1 Banners', 'pointe'),
            'params'  => [
                'pointe_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Background Image', 'pointe'),
                ],
                'pointe_add_image'     => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Additional Image', 'pointe'),
                ],
                'pointe_title'         => [
                    'type'    => 'text',
                    'heading' => esc_html__('Title', 'pointe'),
                ],
                'pointe_desc'          => [
                    'type'    => 'textarea',
                    'heading' => esc_html__('Description', 'pointe'),
                ],
                'align' => true,
                'pointe_btn_direction' => [
                    'type'    => 'select',
                    'heading' => esc_html__('Buttons Direction', 'pointe'),
                    'options' => [
                        ''            => esc_html__('Horizontal', 'pointe'),
                        'is-vertical' => esc_html__('Vertical', 'pointe'),
                    ],
                ],
            ]
        ],
        'pointe_use_subtitle_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Subtitle?', 'pointe'),
            'grid'    => 2,
        ],

        'pointe_subtitle_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Subtitle Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__desc',
        ],
        
        'pointe_use_arrows_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Arrows?', 'pointe'),
            'grid'    => 2,
        ],

        'pointe_arrows_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe arrows Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} div.swiper-button-next, {{WRAPPER}} div.swiper-button-prev',
        ],

	]);

	\Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'pointe_main_',
    ], 'pointe_modern_banners');


    \Aheto\Params::add_button_params($shortcode, [
        'add_label' => esc_html__('Add additional button?', 'pointe'),
        'prefix'    => 'pointe_add_',
    ], 'pointe_modern_banners');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix'         => 'pointe_swiper_',
        'include'        => ['effect', 'pagination', 'speed', 'loop', 'autoplay', 'arrows', 'lazy', 'simulate_touch', 'arrows_color', 'arrows_size'],
        'dependency'     => ['template', 'pointe_layout1']
    ]);


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__('Images size for additional image', 'pointe'),
        'prefix'     => 'pointe_',
        'dependency' => ['template', ['pointe_layout1']]
    ]);
}


function pointe_banner_slider_layout1_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_use_subtitle_typo']) && !empty($shortcode->atts['pointe_subtitle_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-banner-slider__desc'], $shortcode->parse_typography($shortcode->atts['pointe_subtitle_typo']));
    }
    if ( !empty($shortcode->atts['pointe_arrows_color']) ) {
        $css['global'][ '%1$s .swiper-button-next, %1$s .swiper-button-prev']['color'] = Sanitize::color($shortcode->atts['pointe_arrows_color']);
	}
	
	if ( !empty($shortcode->atts['pointe_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['pointe_arrows_size'] );
    }

    return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'pointe_banner_slider_layout1_dynamic_css', 10, 2);