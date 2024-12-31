<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_testimonials_register', 'ninedok_testimonials_layout1' );

/**
 * Testimonials
 */

function ninedok_testimonials_layout1 ( $shortcode )
{

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode -> add_layout ( 'ninedok_layout1', [
		'title' => esc_html__ ( 'Testimonials 19', 'ninedok' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );

	$shortcode -> add_dependecy ( 'ninedok_bg_text', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_testimonials', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_dark_version', 'template', 'ninedok_layout1' );
	$shortcode -> add_dependecy ( 'ninedok_use_banner_text', 'template', 'ninedok_layout1');
	$shortcode -> add_dependecy ( 'ninedok_t_banner_text', 'template', 'ninedok_layout1');
	$shortcode -> add_dependecy ( 'ninedok_t_banner_text', 'ninedok_use_banner_text', 'true');

	$shortcode -> add_params ( [
		'ninedok_dark_version' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Enable dark version?', 'ninedok' ),
			'grid' => 3,
		],
		'ninedok_bg_text' => [
			'type' => 'text',
			'heading' => esc_html__ ( 'Background text', 'ninedok' ),
			'default' => esc_html__ ( 'THEY SAY', 'ninedok' ),
		],
		'ninedok_testimonials' => [
			'type' => 'group',
			'heading' => esc_html__ ( 'Modern Testimonials Items', 'ninedok' ),
			'params' => [
				'ninedok_image' => [
					'type' => 'attach_image',
					'heading' => esc_html__ ( 'Display Image', 'ninedok' ),
				],
				'ninedok_name' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'Name', 'ninedok' ),
					'default' => esc_html__ ( 'Author name', 'ninedok' ),
				],
				'ninedok_company' => [
					'type' => 'text',
					'heading' => esc_html__ ( 'Position', 'ninedok' ),
					'default' => esc_html__ ( 'Author position', 'ninedok' ),
				],
				'ninedok_testimonial' => [
					'type' => 'textarea',
					'heading' => esc_html__ ( 'Testimonial', 'ninedok' ),
					'default' => esc_html__ ( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'ninedok' ),
				],
			],
		],
		'ninedok_use_banner_text'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for background text?', 'ninedok'),
			'grid'    => 6,
		],
		'ninedok_t_banner_text'       => [
			'type'     => 'typography',
			'group'    => 'Ninedok Background Text Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__bg-text',
		],
	] );

	\Aheto\Params ::add_image_sizer_params ( $shortcode, [
		'prefix' => 'ninedok_',
		'dependency' => [ 'template', [ 'ninedok_layout1' ] ]
	] );
	\Aheto\Params ::add_carousel_params ( $shortcode, [
		'custom_options' => true,
		'include' => [ 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch' ],
		'prefix' => 'ninedok_swiper_',
		'dependency' => [ 'template', [ 'ninedok_layout1' ] ]
	] );

}
function ninedok_testimonials_layout1_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['ninedok_use_banner_text']) && !empty($shortcode->atts['ninedok_t_banner_text'])) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__bg-text'], $shortcode->parse_typography($shortcode->atts['ninedok_t_banner_text']));
	}

	return $css;
}

add_filter('aheto_testimonials_dynamic_css', 'ninedok_testimonials_layout1_dynamic_css', 10, 2);