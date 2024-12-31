<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'djo_team_member_layout1');

/**
 * Team member
 */

function djo_team_member_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout('djo_layout1', [
		'title' => esc_html__('Team member 2', 'djo'),
		'image' => $preview_dir . 'djo_layout1.jpg',
	]);

	aheto_demos_add_dependency(['image', 'name', 'designation', 'networks'], ['djo_layout1'], $shortcode);

	$shortcode->add_dependecy('djo_align', 'template', 'djo_layout1');
	$shortcode->add_dependecy( 'djo_use_soc', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_soc_typo', 'template', 'djo_layout1' );
	$shortcode->add_dependecy( 'djo_soc_typo', 'djo_use_soc', 'true' );
	$shortcode->add_params([
		'djo_align' => [
			'type'    => 'select',
			'heading' => esc_html__('Align', 'djo'),
			'options' => \Aheto\Helper::choices_alignment(),
		],
		'djo_use_soc' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for socials?', 'djo' ),
			'grid'    => 6,
		],

		'djo_soc_typo' => [
			'type'     => 'typography',
			'group'    => 'Socials Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .djo-team-member__link',
		],
	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'djo_',
		'dependency' => ['template', ['djo_layout1']]
	]);
}
function djo_team_member_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['djo_use_soc']) && $shortcode->atts['djo_use_soc'] && isset($shortcode->atts['djo_soc_typo'])  && !empty($shortcode->atts['djo_soc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .djo-team-member__link'], $shortcode->parse_typography($shortcode->atts['djo_soc_typo']));
	}

	return $css;
}

add_filter('aheto_team_member_dynamic_css', 'djo_team_member_layout1_dynamic_css', 10, 2);
