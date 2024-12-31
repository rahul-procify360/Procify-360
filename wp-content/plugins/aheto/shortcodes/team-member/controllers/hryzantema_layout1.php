<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'hryzantema_team_member_layout1');

/**
 * HR Consult Team member shortcode
 */

function hryzantema_team_member_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Team member 5', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );
	aheto_demos_add_dependency([ 'image', 'name', 'designation', 'networks'], ['hryzantema_layout1' ], $shortcode);

	$shortcode->add_dependecy( 'hryzantema_use_title_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_title_typo', 'hryzantema_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_position_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_position_typo', 'template', 'hryzantema_layout1' );
	$shortcode->add_dependecy( 'hryzantema_position_typo', 'hryzantema_use_position_typo', 'true' );

	$shortcode->add_params( [
		'hryzantema_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'hryzantema_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_position_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__position',
		],
		'networks' => true

	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'      => esc_html__( 'Hryzantema Images size for team photos ', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'dependency' => ['template', [ 'hryzantema_layout1'] ]
	]);
}
function hryzantema_team_member_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_title_typo'] ) && $shortcode->atts['hryzantema_use_title_typo'] && isset( $shortcode->atts['hryzantema_title_typo'] ) && ! empty( $shortcode->atts['hryzantema_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography( $shortcode->atts['hryzantema_title_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_position_typo'] ) &&  $shortcode->atts['hryzantema_use_position_typo'] && isset( $shortcode->atts['hryzantema_position_typo'] ) && ! empty( $shortcode->atts['hryzantema_position_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography( $shortcode->atts['hryzantema_position_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_team_member_dynamic_css', 'hryzantema_team_member_layout1_dynamic_css', 10, 2 );
