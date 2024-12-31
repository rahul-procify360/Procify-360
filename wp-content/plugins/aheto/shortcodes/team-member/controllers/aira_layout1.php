<?php

use Aheto\Helper;
use Aheto\Sanitize;

add_action( 'aheto_before_aheto_team-member_register', 'aira_team_member_layout1' );


/**
 *  Team member shortcode
 */
function aira_team_member_layout1( $shortcode) {

    $dir = '//assets.aheto.co/team-member/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Consult Team Member', 'aira' ),
        'image' => $dir . 'aira_layout1.jpg',
    ] );

    aheto_demos_add_dependency( ['name','designation','networks','image'], ['aira_layout1'], $shortcode );

    $shortcode->add_dependecy( 'aira_use_title_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_title_typo', 'aira_use_title_typo', 'true' );
    $shortcode->add_dependecy( 'aira_use_position_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_position_typo', 'aira_use_position_typo', 'true' );

    $shortcode->add_params( [

        'aira_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for name?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Name Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__name',
        ],
        'aira_use_position_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for position?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_position_typo' => [
            'type'     => 'typography',
            'group'    => 'Position Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__position',
        ],
        'networks' => true
    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for images ', 'aira' ),
        'prefix'     => 'aira_',
        'dependency' => ['template', [ 'aira_layout1'] ]
    ]);
}
function aira_team_member_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['aira_use_title_typo'] ) && ! empty( $shortcode->atts['aira_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography( $shortcode->atts['aira_title_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['aira_use_position_typo'] ) && ! empty( $shortcode->atts['aira_position_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography( $shortcode->atts['aira_position_typo'] ) );
    }
    return $css;
}
add_filter( 'aheto_dynamic_css_team-member', 'aira_team_member_layout1_dynamic_css', 10, 2 );

