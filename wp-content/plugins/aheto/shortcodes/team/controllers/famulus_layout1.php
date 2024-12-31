<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team_register', 'famulus_team_layout1');

/**
 * Social Networks
 */

function famulus_team_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/team/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Team 1', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	$shortcode->add_dependecy('teams', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_use_typo_name', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_name', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_name', 'famulus_use_typo_name', 'true');
	$shortcode->add_dependecy('famulus_use_typo_position', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_position', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_position', 'famulus_use_typo_position', 'true');
	$shortcode->add_dependecy('famulus_use_typo_link', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_link', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_text_typo_link', 'famulus_use_typo_link', 'true');
	$shortcode->add_params([
		'teams' => [
			'type'    => 'group',
			'heading' => esc_html__('Team', 'famulus'),
			'params'  => [
				'member_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'famulus'),
				],
				'member_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'famulus'),
				],
				'member_designation' => [
					'type'    => 'text',
					'heading' => esc_html__('Designation', 'famulus'),
				],

				'member_social' => [
					'type'    => 'checkbox',
					'heading' => esc_html__('Add socials?', 'famulus'),
				],
			],
		],
		'advanced'      => true,
		'famulus_use_typo_name' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for name?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_name'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-member__name',
		],
		'famulus_use_typo_position' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_position'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-member__position',
		],
		'famulus_use_typo_link' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for link?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_text_typo_link'     => [
			'type'     => 'typography',
			'group'    => 'Famulus Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-member__link',
		],
	]);
	\Aheto\Params::add_networks_params($shortcode, [
		'prefix'     => 'famulus_',
		'dependency' => ['member_social', 'true']
	], 'teams');
}
function famulus_aheto_team_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_typo_name']) && $shortcode->atts['famulus_use_typo_name'] && isset($shortcode->atts['famulus_text_typo_name']) && !empty($shortcode->atts['famulus_text_typo_name']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__name'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_hightlight']));
	}
	if ( isset($shortcode->atts['famulus_use_typo_position']) && $shortcode->atts['famulus_use_typo_position'] && isset($shortcode->atts['famulus_text_typo_position']) && !empty($shortcode->atts['famulus_text_typo_position']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__position'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_position']));
	}
	if ( isset($shortcode->atts['famulus_use_typo_link']) && $shortcode->atts['famulus_use_typo_link'] && isset($shortcode->atts['famulus_text_typo_link']) && !empty($shortcode->atts['famulus_text_typo_link']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__link'], $shortcode->parse_typography($shortcode->atts['famulus_text_typo_link']));
	}
	return $css;
}

add_filter('aheto_team_dynamic_css', 'famulus_aheto_team_layout1_dynamic_css', 10, 2);