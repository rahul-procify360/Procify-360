<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_team-member_register', 'pointe_team_member_layout1' );
/**
 * Team Member
 */

function pointe_team_member_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/team-member/previews/';

	$shortcode->add_layout('pointe_layout1', [
        'title' => esc_html__('Pointe Team social', 'pointe'),
        'image' => $dir . 'pointe_layout1.jpg',
    ]);

	aheto_demos_add_dependency( ['image', 'name', 'designation', 'networks'], [ 'pointe_layout1' ], $shortcode );
	
	$shortcode->add_dependecy('pointe_use_title_typo', 'template', 'pointe_layout1');
	$shortcode->add_dependecy('pointe_title_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_title_typo', 'pointe_use_title_typo', 'true');

    $shortcode->add_dependecy('pointe_use_position_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_position_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_position_typo', 'pointe_use_position_typo', 'true');
	
	$shortcode->add_params( [
		'pointe_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for name?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Name Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__name, {{WRAPPER}} .aheto-team-member-content-text__title',
		],
		'pointe_use_position_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for position?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_position_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Position Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__position',
        ]
	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'     => 'pointe_',
		'dependency' => ['template', [ 'pointe_layout1'] ]
	]);

}

function pointe_team_member_layout1_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_use_title_typo']) && !empty($shortcode->atts['pointe_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__name, %1$s .aheto-team-member-content-text__title'], $shortcode->parse_typography($shortcode->atts['pointe_title_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_position_typo']) && !empty($shortcode->atts['pointe_position_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['pointe_position_typo']));
    }

    return $css;
}

add_filter( 'aheto_team_member_dynamic_css', 'pointe_team_member_layout1_dynamic_css', 10, 2 );