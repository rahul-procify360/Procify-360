<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'prego_testimonials_layout1');

/**
 * Testimonials
 */

function prego_testimonials_layout1($shortcode) {

    $preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('prego_layout1', [
		'title' => esc_html__('Prego Testimonials Classic', 'prego'),
		'image' => $preview_dir . 'prego_layout1.jpg',
	]);

	$shortcode->add_dependecy('prego_testimonials', 'template', ['prego_layout1']);
    $shortcode->add_dependecy('prego_name_use_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_name_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_name_typo', 'prego_name_use_typo', 'true');
    $shortcode->add_dependecy('prego_text_use_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_text_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_text_typo', 'prego_text_use_typo', 'true');


	$shortcode->add_params([
		'prego_testimonials'   => [
			'type'    => 'group',
			'heading' => esc_html__('Testimonials Items', 'prego'),
			'params'  => [
				'prego_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'prego'),
				],
				'prego_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'prego'),
					'default' => esc_html__('Author name', 'prego'),
				],
				'prego_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'prego'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'prego'),
				],
			],
		],
        'prego_name_use_typo'  => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Name?', 'prego'),
            'grid'    => 3,
        ],
        'prego_name_typo'      => [
            'type'     => 'typography',
            'group'    => 'Prego Name Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__name',
        ],
        'prego_text_use_typo'  => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Text?', 'prego'),
            'grid'    => 3,
        ],
        'prego_text_typo'      => [
            'type'     => 'typography',
            'group'    => 'Prego Text Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__text',
        ]
	]);


	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'group'          => 'Prego Swiper',
		'include'        => ['loop', 'autoplay', 'speed', 'simulate_touch'],
		'prefix'         => 'prego_tm_swiper_',
		'dependency'     => ['template', ['prego_layout1']]
	]);
}
