<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'ninedok_team_member_layout1');
/**
 * Team Member
 */

function ninedok_team_member_layout1($shortcode)
{
    $dir = '//assets.aheto.co/team-member/previews/';

    $shortcode->add_layout('ninedok_layout1', [
        'title' => esc_html__('Team member 11', 'ninedok'),
        'image' => $dir . 'ninedok_layout1.jpg',
    ]);


    aheto_demos_add_dependency(['image', 'name', 'designation'], ['ninedok_layout1'], $shortcode);

    $shortcode->add_dependecy('ninedok_use_title_typo', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_title_typo', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_title_typo', 'ninedok_use_title_typo', 'true');
    $shortcode->add_dependecy('ninedok_use_position_typo', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_position_typo', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_position_typo', 'ninedok_use_position_typo', 'true');


    $shortcode->add_params([
        'ninedok_use_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for name?', 'ninedok'),
            'grid' => 3,
        ],
        'ninedok_title_typo' => [
            'type' => 'typography',
            'group' => 'Name Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__name',
        ],
        'ninedok_use_position_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Designation?', 'ninedok'),
            'grid' => 3,
        ],
        'ninedok_position_typo' => [
            'type' => 'typography',
            'group' => 'Position Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__position',
        ],

    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'ninedok_',
        'dependency' => ['template', ['ninedok_layout1']]
    ]);

}

function ninedok_team_member_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ninedok_use_title_typo']) && !empty($shortcode->atts['ninedok_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['ninedok_title_typo']));
    }
    if (!empty($shortcode->atts['ninedok_use_position_typo']) && !empty($shortcode->atts['ninedok_position_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['ninedok_position_typo']));
    }


    return $css;
}

add_filter('aheto_team_member_dynamic_css', 'ninedok_team_member_layout1_dynamic_css', 10, 2);