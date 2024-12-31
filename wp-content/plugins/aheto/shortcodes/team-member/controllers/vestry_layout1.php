<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'vestry_team_member_layout1');

/**
 * Team Member
 */

function vestry_team_member_layout1($shortcode) {
	$dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout('vestry_layout1', [
		'title' => esc_html__('Team member 14', 'vestry'),
		'image' => $dir . 'vestry_layout1.jpg',
	]);

	aheto_demos_add_dependency(['image', 'name', 'designation', 'networks'], ['vestry_layout1'], $shortcode);

	$shortcode->add_dependecy('vestry_use_title_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_title_typo', 'vestry_use_title_typo', 'true');

	$shortcode->add_dependecy('vestry_use_position_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_position_typo', 'template', 'vestry_layout1');
	$shortcode->add_dependecy('vestry_position_typo', 'vestry_use_position_typo', 'true');
  
	$shortcode->add_params([
		'vestry_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'vestry_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'vestry'),
			'grid'    => 3,
		],
		'vestry_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__position',
		],
		'networks' => true
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Images size', 'vestry'),
		'prefix'     => 'vestry_',
		'dependency' => ['template', ['vestry_layout1']]
	]);
}

function vestry_team_member_layout1_dynamic_css($css, $shortcode)
{

  if (!empty($shortcode->atts['vestry_use_title_typo']) && !empty($shortcode->atts['vestry_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['vestry_title_typo']));
	}
	if (!empty($shortcode->atts['vestry_use_position_typo']) && !empty($shortcode->atts['vestry_position_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['vestry_position_typo']));
	}

  return $css;
}

add_filter('aheto_team_member_dynamic_css', 'vestry_team_member_layout1_dynamic_css', 10, 2);