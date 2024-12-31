<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_team-member_register', 'outsourceo_team_member_layout1' );

/**
 * Team member shortcode
 */
function outsourceo_team_member_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Team member 12', 'outsourceo' ),
		'image' => $dir . 'outsourceo_layout1.jpg',
	] );


	aheto_demos_add_dependency( ['image', 'position', 'name', 'designation'], [ 'outsourceo_layout1' ], $shortcode );

	$shortcode->add_dependecy( 'outsourceo_use_title_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_title_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_title_typo', 'outsourceo_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_use_position_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_position_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_position_typo', 'outsourceo_use_position_typo', 'true' );

	$shortcode->add_params( [
		'outsourceo_use_title_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'outsourceo_use_position_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_position_typo'     => [
			'type'     => 'typography',
			'group'    => 'Position Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__position',
		],

	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'prefix'     => 'outsourceo_',
		'dependency' => [ 'template', [ 'outsourceo_layout1' ] ]
	] );

}

function outsourceo_team_member_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_title_typo'] ) && ! empty( $shortcode->atts['outsourceo_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography( $shortcode->atts['outsourceo_title_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['outsourceo_use_position_typo'] ) && ! empty( $shortcode->atts['outsourceo_position_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography( $shortcode->atts['outsourceo_position_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_team_member_dynamic_css', 'outsourceo_team_member_layout1_dynamic_css', 10, 2 );