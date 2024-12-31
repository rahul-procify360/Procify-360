<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team_register', 'funero_team_layout1');

/**
 * Team shortcode
 */

function funero_team_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/team/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Team 3', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);


	$shortcode->add_dependecy('funero_team', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_author_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_author_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_author_typo', 'funero_author_use_typo', 'true');
	$shortcode->add_dependecy('funero_position_use_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_position_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_position_typo', 'funero_position_use_typo', 'true');
	$shortcode->add_params([
		'funero_team'              => [
			'type'    => 'group',
			'heading' => esc_html__('Team', 'funero'),
			'params'  => [
				'funero_member_image'    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'funero'),
				],
				'funero_member_name'     => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'funero'),
				],
				'funero_member_position' => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'funero'),
				],
			],
		],
		'funero_author_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Author?', 'funero'),
			'grid'    => 3,
		],
		'funero_author_typo'       => [
			'type'     => 'typography',
			'group'    => 'Funero Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-member__name',
		],
		'funero_position_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Position?', 'funero'),
			'grid'    => 3,
		],
		'funero_position_typo'     => [
			'type'     => 'typography',
			'group'    => 'Funero Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-member__position',
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'    => 'Funero Image',
		'dependency' => ['template', ['funero_layout1']]
	]);
}

function funero_team_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['funero_position_use_typo']) &&  $shortcode->atts['funero_position_use_typo'] && isset($shortcode->atts['funero_position_typo']) && !empty($shortcode->atts['funero_position_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__position'], $shortcode->parse_typography($shortcode->atts['funero_position_typo']));
	}
	if ( isset($shortcode->atts['funero_author_use_typo']) &&  $shortcode->atts['funero_author_use_typo'] && isset($shortcode->atts['funero_author_typo'])  && !empty($shortcode->atts['funero_author_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__name'], $shortcode->parse_typography($shortcode->atts['funero_author_typo']));
	}

	return $css;
}
add_filter('aheto_team_dynamic_css', 'funero_team_layout1_dynamic_css', 10, 2);
