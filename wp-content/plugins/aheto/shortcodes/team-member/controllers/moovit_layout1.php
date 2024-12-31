<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_team-member_register', 'moovit_team_member_layout1' );
/**
 * Team Member
 */

function moovit_team_member_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout( 'moovit_layout1', [
		'title' => esc_html__( 'Team member 10', 'moovit' ),
		'image' => $dir . 'moovit_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['image', 'name', 'designation'], [ 'moovit_layout1' ], $shortcode );

	$shortcode->add_dependecy('moovit_background', 'template', 'moovit_layout1');

	$shortcode->add_dependecy( 'moovit_use_title_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_title_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_title_typo', 'moovit_use_title_typo', 'true' );

	$shortcode->add_dependecy( 'moovit_use_designation_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_designation_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_designation_typo', 'moovit_use_designation_typo', 'true' );

	$shortcode->add_dependecy( 'moovit_use_link', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_link_text', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_link_text', 'moovit_use_link', 'true' );
	$shortcode->add_dependecy( 'moovit_link_typo', 'template', 'moovit_layout1' );
	$shortcode->add_dependecy( 'moovit_link_typo', 'moovit_use_link', 'true' );
	$shortcode->add_dependecy( 'moovit_link_url', 'template', [ 'moovit_layout1' ] );
	$shortcode->add_dependecy( 'moovit_link_url', 'moovit_use_link', 'true' );

	$shortcode->add_params( [
		'moovit_background' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Background color', 'moovit' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-team-member__text' => 'background: {{VALUE}}' ],
		],
		'moovit_use_title_typo'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for name?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_title_typo'        => [
			'type'     => 'typography',
			'group'    => 'Moovit Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__name',
		],
		'moovit_use_designation_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for position?', 'moovit' ),
			'grid'    => 3,
		],
		'moovit_designation_typo'     => [
			'type'     => 'typography',
			'group'    => 'Moovit Designation Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__position',
		],
		'moovit_use_link'       => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use Link?', 'moovit' ),
			'grid'    => 12,
		],
		'moovit_link_text'     => [
			'type'    => 'text',
			'heading' => esc_html__( 'Link Text', 'moovit' ),
			'default' => 'Click Me'
		],
		'moovit_link_typo'        => [
			'type'     => 'typography',
			'group'    => 'Moovit Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-team-member__link',
		],
		'moovit_link_url'      => [
			'type'    => 'link',
			'heading' => esc_html__( 'Link URL', 'moovit' ),
			'description' => esc_html__( 'Add url to item.', 'moovit' ),
			'default'     => [
				'url' => '#',
			],
		],

	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'moovit_',
		'dependency' => ['template', [ 'moovit_layout1'] ]
	]);

}

function moovit_team_member_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_background'] ) ) {
		$color                                                        = Sanitize::color( $shortcode->atts['moovit_background'] );
		$css['global']['%1$s .aheto-team-member__text']['background'] = $color;
	}

	if ( ! empty( $shortcode->atts['moovit_use_title_typo'] ) && ! empty( $shortcode->atts['moovit_title_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography( $shortcode->atts['moovit_title_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['moovit_use_designation_typo'] ) && ! empty( $shortcode->atts['moovit_designation_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography( $shortcode->atts['moovit_designation_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['moovit_use_link'] ) && ! empty( $shortcode->atts['moovit_link_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-team-member__link'], $shortcode->parse_typography( $shortcode->atts['moovit_link_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_team_member_dynamic_css', 'moovit_team_member_layout1_dynamic_css', 10, 2 );