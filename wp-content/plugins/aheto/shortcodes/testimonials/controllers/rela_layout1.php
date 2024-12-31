<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'rela_testimonials_layout1');


/**
 * Testimonials Shortcode
 */
function rela_testimonials_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/testimonials/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Testimonials 24', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_testimonials', 'template', 'rela_layout1');


    $shortcode->add_params([
        'rela_testimonials' => [
            'type' => 'group',
            'heading' => esc_html__('Modern Testimonials Items', 'rela'),
            'params' => [
                'rela_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Author photo', 'rela'),
                ],
                'rela_name' => [
                    'type' => 'text',
                    'heading' => esc_html__('Name', 'rela'),
                    'default' => esc_html__('Author name', 'rela'),
                ],
                'rela_company' => [
                    'type' => 'text',
                    'heading' => esc_html__('Position', 'rela'),
                    'default' => esc_html__('Author position', 'rela'),
                ],
                'rela_testimonial' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Testimonial', 'rela'),
                    'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'rela'),
                ],
            ],
        ],
    ]);

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'rela_swiper_',
        'include' => ['loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
        'dependency' => ['template', ['rela_layout1']]
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_',
        'dependency' => ['template', ['rela_layout1']]
    ]);
}