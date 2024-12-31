<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'djo_testimonials_layout2');

/**
 * Testimonial member
 */

function djo_testimonials_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('djo_layout2', [
		'title' => esc_html__('Testimonials 3', 'djo'),
		'image' => $preview_dir . 'djo_layout2.jpg',
	]);


	$shortcode->add_dependecy('djo_dark_version', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_centered', 'template', 'djo_layout2');
	$shortcode->add_dependecy('djo_testimonials_creative_item', 'template', 'djo_layout2');
	$shortcode->add_dependecy( 'djo_use_title', 'template', 'djo_layout2' );
	$shortcode->add_dependecy( 'djo_title_typo', 'template', 'djo_layout2' );
	$shortcode->add_dependecy( 'djo_title_typo', 'djo_use_title', 'true' );

	$shortcode->add_dependecy( 'djo_use_text', 'template', 'djo_layout2' );
	$shortcode->add_dependecy( 'djo_text_typo', 'template', 'djo_layout2' );
	$shortcode->add_dependecy( 'djo_text_typo', 'djo_use_text', 'true' );

	$shortcode->add_dependecy( 'djo_use_name', 'template', 'djo_layout2' );
    $shortcode->add_dependecy( 'djo_name_typo', 'template', 'djo_layout2' );
    $shortcode->add_dependecy( 'djo_name_typo', 'djo_use_name', 'true' );

    $shortcode->add_dependecy( 'djo_use_position', 'template', 'djo_layout2' );
    $shortcode->add_dependecy( 'djo_position_typo', 'template', 'djo_layout2' );
    $shortcode->add_dependecy( 'djo_position_typo', 'djo_use_position', 'true' );


	$shortcode->add_params([
		'djo_dark_version'               => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable light version?', 'djo'),
			'grid'    => 3,
		],
		'djo_centered'               => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable centered slides?', 'djo'),
			'description' => esc_html__('If true, then active slide will be centered, not always on the left side', 'djo'),
			'grid'    => 3,
		],
		'djo_testimonials_creative_item' => [
			'type'    => 'group',
			'heading' => esc_html__('Modern Testimonials Items', 'djo'),
			'params'  => [
				'djo_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'djo'),
				],
				'djo_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'djo'),
					'default' => esc_html__('Author name', 'djo'),
				],
				'djo_company'     => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'djo'),
					'default' => esc_html__('Author position', 'djo'),
				],
				'djo_title' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial title', 'djo'),
					'default' => esc_html__('Just Wow!', 'djo'),
				],
				'djo_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'djo'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'djo'),
				],
			],
		],
		'djo_use_title' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for title?', 'djo' ),
			'grid'    => 6,
		],

		'djo_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__title',
		],
		'djo_use_text' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for text?', 'djo' ),
			'grid'    => 6,
		],

		'djo_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Text Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'djo_use_name' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'djo' ),
			'grid'    => 6,
		],

		'djo_name_typo' => [
			'type'     => 'typography',
			'group'    => 'Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'djo_use_position' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'djo' ),
			'grid'    => 6,
		],

		'djo_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
	]);

	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'djo_swiper_',
		'include'        => ['speed', 'loop', 'autoplay', 'spaces', 'slides', 'simulate_touch'],
		'dependency'     => ['template', ['djo_layout2']]
	]);
}
function djo_testimonials_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_title']) && $shortcode->atts['djo_use_title'] && isset($shortcode->atts['djo_title_typo']) && !empty($shortcode->atts['djo_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__title'], $shortcode->parse_typography($shortcode->atts['djo_title_typo']));
	}
	if ( isset($shortcode->atts['djo_use_text']) && $shortcode->atts['djo_use_text'] && isset($shortcode->atts['djo_text_typo']) && !empty($shortcode->atts['djo_text_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['djo_text_typo']));
	}
	if ( isset($shortcode->atts['djo_use_name']) && $shortcode->atts['djo_use_name'] && isset($shortcode->atts['djo_name_typo']) && !empty($shortcode->atts['djo_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['djo_name_typo']));
	}
	if ( isset($shortcode->atts['djo_use_position']) && $shortcode->atts['djo_use_position'] && isset($shortcode->atts['djo_position_typo']) && !empty($shortcode->atts['djo_position_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['djo_position_typo']));
	}

	return $css;
}

add_filter('aheto_testimonials_dynamic_css', 'djo_testimonials_layout1_dynamic_css', 10, 2);
