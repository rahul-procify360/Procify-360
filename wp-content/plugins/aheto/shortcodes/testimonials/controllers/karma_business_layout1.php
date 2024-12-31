<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'karma_business_testimonials_layout1');

/**
 * Navbar
 */

function karma_business_testimonials_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

	$shortcode->add_layout('karma_business_layout1', [
		'title' => esc_html__('Testimonials 10', 'karma'),
		'image' => $preview_dir . 'karma_business_layout1.jpg',
	]);

	aheto_demos_add_dependency( 'testimonials', ['karma_business_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_business_use_text_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_text_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_text_typo', 'karma_business_use_text_typo', 'true');

	$shortcode->add_dependecy('karma_business_use_author_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_author_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_author_typo', 'karma_business_use_author_typo', 'true');

	$shortcode->add_dependecy('karma_business_use_position_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_position_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_position_typo', 'karma_business_use_position_typo', 'true');

	$shortcode->add_params([
		'karma_business_use_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
		],
		'karma_business_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__text',
		],
		'karma_business_use_author_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'karma'),
		],
		'karma_business_author_typo' => [
			'type'     => 'typography',
			'group'    => 'Name Typography',
			'settings' => [
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__name',
		],
		'karma_business_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Position?', 'karma'),
		],
		'karma_business_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-tm__position',
		],

	]);

	\Aheto\Params::add_carousel_params($shortcode, [
	    'group'      => esc_html__( 'Karma Business Swiper ', 'karma' ),
		'custom_options' => true,
		'prefix'         => 'karma_business_swiper_',
		'include'        => ['arrows', 'pagination', 'loop', 'simulate_touch', 'autoplay', 'speed', 'slides', 'spaces', ],
		'dependency'     => ['template', ['karma_business_layout1']]
	]);

}

function karma_business_testimonials_shortcode_dynamic_css($css, $shortcode) {

	if (!empty($shortcode->atts['karma_business_use_title_typo']) && !empty($shortcode->atts['karma_business_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['karma_business_title_typo']));
	}

	if (!empty($shortcode->atts['karma_business_use_author_typo']) && !empty($shortcode->atts['karma_business_author_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['karma_business_author_typo']));
	}

	if (!empty($shortcode->atts['karma_business_use_position_typo']) && !empty($shortcode->atts['karma_business_position_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['karma_business_position_typo']));
	}

	return $css;

}
add_filter('aheto_testimonials_dynamic_css', 'karma_business_testimonials_shortcode_dynamic_css', 10, 2);
