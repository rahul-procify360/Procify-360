<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'karma_events_team_member_layout1');
/**
 * Team Member
 */

function karma_events_team_member_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout('karma_events_layout1', [
		'title' => esc_html__('Team member 7', 'karma'),
		'image' => $preview_dir . 'karma_events_layout1.jpg',
	]);

	aheto_demos_add_dependency(['image', 'name', 'designation', 'image_size', 'networks'], ['karma_events_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_events_use_link_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_link_typo', 'karma_events_use_link_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_position_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_position_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_position_typo', 'karma_events_use_position_typo', 'true');
	$shortcode->add_dependecy('karma_events_use_name_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_name_typo', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_name_typo', 'karma_events_use_name_typo', 'true');
	$shortcode->add_dependecy('karma_events_align', 'template', 'karma_events_layout1');

	$shortcode->add_params([
		'karma_events_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'karma'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'karma_events_use_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Links?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__link',
		],
		'karma_events_use_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_name_typo'     => [
			'type'     => 'typography',
			'group'    => 'Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'karma_events_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Position?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_position_typo'     => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__position',
		],
	]);

}
function karma_events_team_member_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_events_use_link_typo']) && $shortcode->atts['karma_events_use_link_typo'] && isset($shortcode->atts['karma_events_link_typo']) && !empty($shortcode->atts['karma_events_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__link'], $shortcode->parse_typography($shortcode->atts['karma_events_link_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_name_typo']) && $shortcode->atts['karma_events_use_name_typo'] && isset($shortcode->atts['karma_events_name_typo']) && !empty($shortcode->atts['karma_events_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['karma_events_name_typo']));
	}
	if ( isset($shortcode->atts['karma_events_use_position_typo']) && $shortcode->atts['karma_events_use_position_typo'] && isset($shortcode->atts['karma_events_position_typo']) && !empty($shortcode->atts['karma_events_position_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['karma_events_position_typo']));
	}

	return $css;
}

add_filter( 'aheto_team_member_dynamic_css', 'karma_events_team_member_layout1_dynamic_css', 10, 2 );