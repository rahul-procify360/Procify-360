<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team_register', 'soapy_team_layout1');

/**
 * Social Networks
 */

function soapy_team_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/team/previews/';

	$shortcode->add_layout('soapy_layout1', [
		'title' => esc_html__('Team 4', 'soapy'),
		'image' => $preview_dir . 'soapy_layout1.jpg',
	]);

	$shortcode->add_dependecy('soapy_team', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_author_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_author_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_author_typo', 'soapy_author_use_typo', 'true');
	$shortcode->add_dependecy('soapy_position_use_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_position_typo', 'template', 'soapy_layout1');
	$shortcode->add_dependecy('soapy_position_typo', 'soapy_position_use_typo', 'true');
	$shortcode->add_params([
		'soapy_team'              => [
			'type'    => 'group',
			'heading' => esc_html__('Team', 'soapy'),
			'params'  => [
				'soapy_member_image'    => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'soapy'),
				],
				'soapy_member_name'     => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'soapy'),
				],
				'soapy_member_position' => [
					'type'    => 'text',
					'heading' => esc_html__('Position', 'soapy'),
				],
			],
		],
		'soapy_author_use_typo'   => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for author?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_author_typo'       => [
			'type'     => 'typography',
			'group'    => 'Soapy Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-member__name',
		],
		'soapy_position_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for position?', 'soapy'),
			'grid'    => 3,
		],
		'soapy_position_typo'     => [
			'type'     => 'typography',
			'group'    => 'Soapy Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-member__position',
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix' => 'soapy_',
		'dependency' => ['template', ['soapy_layout1']]
	]);
}
function soapy_team_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['soapy_position_use_typo']) && $shortcode->atts['soapy_position_use_typo'] && isset($shortcode->atts['soapy_position_typo']) && !empty($shortcode->atts['soapy_position_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__position'], $shortcode->parse_typography($shortcode->atts['soapy_position_typo']));
	}
	if ( isset($shortcode->atts['soapy_author_use_typo']) && !empty($shortcode->atts['soapy_author_use_typo']) && isset($shortcode->atts['soapy_author_typo']) && !empty($shortcode->atts['soapy_author_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-member__name'], $shortcode->parse_typography($shortcode->atts['soapy_author_typo']));
	}

	return $css;
}
add_filter('aheto_team_dynamic_css', 'soapy_team_layout1_dynamic_css', 10, 2);

