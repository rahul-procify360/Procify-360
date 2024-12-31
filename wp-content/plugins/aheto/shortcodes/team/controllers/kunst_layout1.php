<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_team_register', 'kunst_team_layout1' );

function kunst_team_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/team/previews/';

	$shortcode->add_layout( 'kunst_layout1', [
		'title' => esc_html__( 'Team Member', 'kunst' ),
		'image' => $preview_dir . 'kunst_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'kunst_teams', 'template', 'kunst_layout1' );

	$shortcode->add_dependecy( 'kunst_use_person_name_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_person_name_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_person_name_typo', 'kunst_use_person_name_typo', 'true' );

	$shortcode->add_dependecy( 'kunst_use_designation_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_designation_typo', 'template', 'kunst_layout1' );
	$shortcode->add_dependecy( 'kunst_designation_typo', 'kunst_use_designation_typo', 'true' );

	$shortcode->add_params([

		'kunst_teams'       => [
			'type'    => 'group',
			'heading' => esc_html__('Team', 'kunst'),
			'params'  => [
				'kunst_member_image'       => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Display Image', 'kunst'),
				],
				'kunst_member_name'        => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'kunst'),
				],
				'kunst_member_designation' => [
					'type'    => 'text',
					'heading' => esc_html__('Designation', 'kunst'),
				],
				'kunst_member_social' => [
					'type'    => 'checkbox',
					'heading' => esc_html__('Add socials?', 'kunst'),
				],
			],
		],

		'kunst_use_person_name_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Person Name?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_person_name_typo'        => [
			'type'     => 'typography',
			'group'    => 'Person Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team--name',
		],

		'kunst_use_designation_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Designation?', 'kunst' ),
			'grid'    => 3,
		],
		'kunst_designation_typo'        => [
			'type'     => 'typography',
			'group'    => 'Designation Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team--position',
		],
		'advanced'    => true,

	]);

	\Aheto\Params::add_networks_params($shortcode, [
		'prefix'     => 'kunst',
		'dependency' => [ 'kunst_member_social', 'true' ]
	], 'kunst_teams' );
}

function kunst_team_layout1_dynamic_css( $css, $shortcode ) {

	if ( !empty($shortcode->atts['kunst_use_person_name_typo']) && !empty($shortcode->atts['kunst_person_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-team--name'], $shortcode->parse_typography($shortcode->atts['kunst_person_name_typo']));
	}

	if ( !empty($shortcode->atts['kunst_use_designation_typo']) && !empty($shortcode->atts['kunst_designation_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-team--position'], $shortcode->parse_typography($shortcode->atts['kunst_designation_typo']));
	}

	return $css;

}

add_filter('aheto_team_dynamic_css', 'kunst_team_layout1_dynamic_css', 10, 2);
