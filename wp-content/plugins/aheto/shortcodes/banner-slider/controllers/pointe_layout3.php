<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'pointe_banner_slider_layout3');

/**
 *  Banner Slider
 */

function pointe_banner_slider_layout3($shortcode)
{

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

	$shortcode->add_layout('pointe_layout3', [
		'title' => esc_html__('Banner Slider 23', 'pointe'),
		'image' => $preview_dir . 'pointe_layout3.jpg',
	]);

    $shortcode->add_dependecy('pointe_grid_banners', 'template', 'pointe_layout3');
    
    $shortcode->add_dependecy('pointe_use_arrows_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_arrows_typo', 'template', 'pointe_layout3');
    $shortcode->add_dependecy('pointe_arrows_typo', 'pointe_use_arrows_typo', 'true');

	aheto_demos_add_dependency(['use_heading', 't_heading'], ['pointe_layout3'], $shortcode);

	$shortcode->add_params([
		'pointe_grid_banners' => [

            'type'    => 'group',
            'heading' => esc_html__('Pointe Banners', 'pointe'),
            'params'  => [
                'pointe_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Background Image', 'pointe'),
                ],
                'pointe_title'         => [
                    'type'    => 'text',
                    'heading' => esc_html__('Title', 'pointe'),
                ],
                'pointe_title_2'         => [
                    'type'    => 'text',
                    'heading' => esc_html__('Title 2', 'pointe'),
                ],
                'pointe_title_3'         => [
                    'type'    => 'text',
                    'heading' => esc_html__('Title 3', 'pointe'),
                ],
            ]
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

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix'         => 'pointe_swiper_',
        'include'        => ['effect', 'pagination', 'speed', 'loop', 'autoplay', 'lazy', 'simulate_touch'],
        'dependency'     => ['template', ['pointe_layout3', 'pointe_layout3', 'pointe_layout3']]
    ]);


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__('Images size for additional image', 'pointe'),
        'prefix'     => 'pointe_',
        'dependency' => ['template', ['pointe_layout3']]
    ]);
}