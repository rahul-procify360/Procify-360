<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'sterling_team_member_layout1');

/**
 *  Team member shortcode
 */

function sterling_team_member_layout1($shortcode)
{
	$dir = '//assets.aheto.co/team-member/previews/';
	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling Team Member', 'sterling'),
		'image' => $dir . 'sterling_layout1.jpg',
	]);

	aheto_demos_add_dependency('image', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('name', ['sterling_layout1'], $shortcode);
	aheto_demos_add_dependency('designation', ['sterling_layout1'], $shortcode);
	$shortcode->add_dependecy('sterling_use_name_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_name_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_name_typo', 'sterling_use_name_typo', 'true');
	$shortcode->add_dependecy('sterling_use_position_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_position_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_position_typo', 'sterling_use_position_typo', 'true');
	$shortcode->add_params([
		'sterling_use_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_name_typo' => [
			'type'     => 'typography',
			'group'    => 'Name Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'sterling_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__position',
		],
		'networks' => true
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__('Images size', 'sterling'),
		'prefix'     => 'sterling_',
		'dependency' => ['template', ['sterling_layout1']]
	]);
}

function sterling_team_member_layout1_dynamic_css($css, $shortcode)
{
	if (!empty($shortcode->atts['sterling_use_name_typo']) && !empty($shortcode->atts['sterling_name_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['sterling_name_typo']));
	}
	if (!empty($shortcode->atts['sterling_use_position_typo']) && !empty($shortcode->atts['sterling_position_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['sterling_position_typo']));
	}
	return $css;
}
add_filter('aheto_dynamic_css_team-member', 'sterling_team_member_layout1_dynamic_css', 10, 2);