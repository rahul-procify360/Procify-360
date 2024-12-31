<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'famulus_team_member_layout1');
/**
 * Team Member
 */

function famulus_team_member_layout1($shortcode) {
	$dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Team member 4', 'famulus'),
		'image' => $dir . 'famulus_layout1.jpg',
	]);

	aheto_demos_add_dependency(['image', 'name', 'designation', 'image_size', 'networks'], ['famulus_layout1'], $shortcode);

	$shortcode->add_dependecy('famulus_use_link_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_link_typo', 'template', 'famulus_layout1');
	$shortcode->add_dependecy('famulus_link_typo', 'famulus_use_link_typo', 'true');
	$shortcode->add_dependecy('famulus_align', 'template', 'famulus_layout1');

	$shortcode->add_params([
		'famulus_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'famulus'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'famulus_use_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Links?', 'famulus'),
			'grid'    => 3,
		],
		'famulus_link_typo'     => [
			'type'     => 'typography',
			'group'    => 'Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__link',
		],
	]);

}
function famulus_aheto_team_member_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['famulus_use_link_typo']) && $shortcode->atts['famulus_use_link_typo'] && isset($shortcode->atts['famulus_link_typo']) && !empty($shortcode->atts['famulus_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-team-member__link'], $shortcode->parse_typography($shortcode->atts['famulus_link_typo']));
	}

	return $css;
}

add_filter('aheto_team_member_dynamic_css', 'famulus_aheto_team_member_layout1_dynamic_css', 10, 2);
