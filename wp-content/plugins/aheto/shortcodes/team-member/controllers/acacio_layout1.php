<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_team-member_register', 'acacio_team_member_layout1' );
/**
 * Team Member
 */

function acacio_team_member_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Team member 1', 'acacio' ),
		'image' => $dir . 'acacio_layout1.jpg',
	] );

	aheto_demos_add_dependency( ['image', 'name', 'designation'], [ 'acacio_layout1' ], $shortcode );

    $shortcode->add_dependecy( 'acacio_use_title_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_title_typo', 'acacio_use_title_typo', 'true' );
    $shortcode->add_dependecy( 'acacio_use_position_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_position_typo', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_position_typo', 'acacio_use_position_typo', 'true' );
    
    $shortcode->add_dependecy( 'acacio_box_shadow_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_border_radius', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_add_border_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_border_color', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_border_color', 'acacio_add_border_color', 'true' );

    $shortcode->add_params( [
        'acacio_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for name?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Name Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__name',
        ],
        'acacio_use_position_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for position?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_position_typo' => [
            'type'     => 'typography',
            'group'    => 'Position Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__position',
        ],

        'acacio_box_shadow_color'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Acacio color for box-shadow', 'acacio' ),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .aheto-team-member--acacio-simple' => 'box-shadow: 0 10px 50px 0 {{VALUE}}'
            ],
        ],

        'acacio_border_radius'  => [
            'type'    => 'text',
            'heading' => esc_html__( 'Acacio border radius for block', 'acacio' ),
            'description' => esc_html__( 'Enter border radius block. Value must be with unit. For example: 5px', 'acacio' ),
            'selectors' => [ '{{WRAPPER}} .aheto-team-member--acacio-simple' => 'border-radius: {{VALUE}}; overflow: hidden' ],
            'grid'    => 6,
        ],

        'acacio_add_border_color' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Add hover to border bottom?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_border_color'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Acacio border color on hover', 'acacio' ),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .aheto-team-member--acacio-simple:hover' => 'border-color: {{VALUE}}'
            ],
        ],
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout1'] ]
    ]);

}

function acacio_team_member_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['acacio_use_title_typo'] ) && ! empty( $shortcode->atts['acacio_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography( $shortcode->atts['acacio_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['acacio_use_position_typo'] ) && ! empty( $shortcode->atts['acacio_position_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography( $shortcode->atts['acacio_position_typo'] ) );
    }

    if ( isset( $shortcode->atts['acacio_box_shadow_color'] ) && ! empty( $shortcode->atts['acacio_box_shadow_color'] ) ) {
		$color                               = Sanitize::color( $shortcode->atts['acacio_box_shadow_color'] );
		$css['global']['%1$s']['box-shadow'] = $color;
	}
    if ( isset( $shortcode->atts['acacio_border_radius'] ) && ! empty( $shortcode->atts['acacio_border_radius'] ) ) {
        $radius                                 = Sanitize::size( $shortcode->atts['acacio_border_radius'] );
		$css['global']['%1$s']['border-radius'] = $radius;
    }
    if ( isset($shortcode->atts['acacio_add_border_color']) && $shortcode->atts['acacio_add_border_color'] && isset( $shortcode->atts['acacio_border_color'] ) && ! empty( $shortcode->atts['acacio_border_color'] ) ) {
        $color                               = Sanitize::color( $shortcode->atts['acacio_border_color'] );
        $css['global']['%1$s']['border-bottom'] = $color;
    }
    

	return $css;
}

add_filter( 'aheto_team_member_dynamic_css', 'acacio_team_member_layout1_dynamic_css', 10, 2 );