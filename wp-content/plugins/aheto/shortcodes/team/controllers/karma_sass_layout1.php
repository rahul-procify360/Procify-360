<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team_register', 'karma_sass_team_layout1');


function karma_sass_team_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/team/previews/';

	$shortcode->add_layout('karma_sass_layout1', [
		'title' => esc_html__('Karma SASS Layout 1', 'karma'),
		'image' => $preview_dir . 'karma_sass_layout1.jpg',
	]);
	$shortcode->add_dependecy('karma_sass_slider', 'template', 'karma_sass_layout1');


	$shortcode->add_dependecy('karma_sass_use_name_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_name_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_name_typo', 'karma_sass_use_name_typo', 'true');

	$shortcode->add_dependecy('karma_sass_use_pos_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_pos_typo', 'template', 'karma_sass_layout1');
	$shortcode->add_dependecy('karma_sass_pos_typo', 'karma_sass_use_pos_typo', 'true');
	$shortcode->add_params([
		'karma_sass_slider' => [
			'type'    => 'group',
			'heading' => esc_html__('Features Slider', 'karma'),
			'params'  => [
				'karma_sass_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'aheto'),
				],
				'karma_sass_name'      => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'karma'),
				],
				'karma_sass_position'      => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'karma'),
				],
			],
		],
		'karma_sass_use_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name text?', 'karma'),
		],
		'karma_sass_name_typo' => [
			'type'     => 'typography',
			'group'    => 'SASS Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team__name',
		],
		'karma_sass_use_pos_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position text?', 'karma'),
		],
		'karma_sass_pos_typo' => [
			'type'     => 'typography',
			'group'    => 'SASS Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team__position',
		],
	]);
	\Aheto\Params::add_carousel_params($shortcode, [
		'prefix'         => 'karma_sass_',
		'custom_options' => true,
		'group'          => 'Karma Swiper',
		'include'        => [
			'arrows',
			'arrows_color',
			'arrows_size',
			'delay',
			'speed',
			'loop',
			'slides',
			'spaces',
			'small',
			'medium',
			'large',
			'simulate_touch'],
		'dependency'     => ['template', ['karma_sass_layout1']]
	]);

	\Aheto\Params::add_networks_params($shortcode, [
		'prefix' => 'karma_sass_',
	], 'karma_sass_slider');
}

function karma_sass_team_layout1_dynamic_css($css, $shortcode)
{

	if (isset($shortcode->atts['karma_sass_use_name_typo']) && $shortcode->atts['karma_sass_use_name_typo'] && isset($shortcode->atts['karma_sass_name_typo']) && !empty($shortcode->atts['karma_sass_name_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team__name'], $shortcode->parse_typography($shortcode->atts['karma_sass_name_typo']));
	}
	if (isset($shortcode->atts['karma_sass_use_pos_typo']) && $shortcode->atts['karma_sass_use_pos_typo'] && isset($shortcode->atts['karma_sass_pos_typo']) && !empty($shortcode->atts['karma_sass_pos_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team__position'], $shortcode->parse_typography($shortcode->atts['karma_sass_pos_typo']));
	}

	return $css;
}
add_filter('karma_team_dynamic_css', 'karma_sass_team_layout1_dynamic_css', 10, 2);
