<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'mooseoom_testimonials_layout2' );

/**
 * Testimonials
 */

function mooseoom_testimonials_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout( 'mooseoom_layout2', [
		'title' => esc_html__( 'Testimonials 16', 'mooseoom' ),
		'image' => $preview_dir . 'mooseoom_layout2.jpg',
	] );

	$shortcode->add_dependecy('mooseoom_testimonials', 'template', ['mooseoom_layout2']);

	$shortcode->add_dependecy('mooseoom_use_text_typo', 'template', ['mooseoom_layout2']);
	$shortcode->add_dependecy('mooseoom_text_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_text_typo', 'mooseoom_use_text_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_name_typo', 'template', ['mooseoom_layout2']);
	$shortcode->add_dependecy('mooseoom_name_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_name_typo', 'mooseoom_use_text_typo', 'true');

	$shortcode->add_dependecy('mooseoom_use_position_typo', 'template', ['mooseoom_layout2']);
	$shortcode->add_dependecy('mooseoom_position_typo', 'template', 'mooseoom_layout2');
	$shortcode->add_dependecy('mooseoom_position_typo', 'mooseoom_use_position_typo', 'true');

	$shortcode->add_params( [
		'mooseoom_testimonials' => [
			'type'    => 'group',
			'heading' => esc_html__('Modern Testimonials Items', 'mooseoom'),
			'params'  => [
				'mooseoom_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'mooseoom'),
				],
				'mooseoom_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'mooseoom'),
					'default' => esc_html__('Author name', 'mooseoom'),
				],
				'mooseoom_company'     => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'mooseoom'),
					'default' => esc_html__('Author position', 'mooseoom'),
				],
				'mooseoom_testimonial' => [
					'type'    => 'textarea',
					'heading' => esc_html__('Testimonial', 'mooseoom'),
					'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'mooseoom'),
				],
			],
		],
		'mooseoom_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for testimonials?', 'mooseoom'),
			'grid'    => 3,
		],
		'mooseoom_text_typo'       => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Testimonials Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'mooseoom_use_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'mooseoom'),
			'grid'    => 4,
		],
		'mooseoom_name_typo'       => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Name Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'mooseoom_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'mooseoom'),
			'grid'    => 4,
		],
		'mooseoom_position_typo'       => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Position Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],
	] );


	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'include'        => ['loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
		'prefix'         => 'mooseoom_swiper_',
		'dependency'     => ['template', ['mooseoom_layout2']]
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'         => 'mooseoom_',
		'dependency' => ['template',  ['mooseoom_layout2' ]]
	]);

}
function mooseoom_testimonials_layout2_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['mooseoom_use_text_typo']) && !empty($shortcode->atts['mooseoom_text_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['mooseoom_text_typo']));
	}
	if (!empty($shortcode->atts['mooseoom_use_name_typo']) && !empty($shortcode->atts['mooseoom_name_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['mooseoom_name_typo']));
	}
	if (!empty($shortcode->atts['mooseoom_use_position_typo']) && !empty($shortcode->atts['mooseoom_position_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['mooseoom_position_typo']));
	}

	return $css;
}

add_filter('aheto_team_member_dynamic_css', 'mooseoom_testimonials_layout2_dynamic_css', 10, 2);