<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'ewo_team_member_layout1');
/**
 * Team Member
 */

function ewo_team_member_layout1($shortcode)
{
    $dir = '//assets.aheto.co/team-member/previews/';

    $shortcode->add_layout('ewo_layout1', [
        'title' => esc_html__('Team member 3', 'ewo'),
        'image' => $dir . 'ewo_layout1.jpg',
    ]);

    aheto_demos_add_dependency(['image', 'name', 'designation'], ['ewo_layout1'], $shortcode);

    $shortcode->add_dependecy('ewo_use_title_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_title_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_title_typo', 'ewo_use_title_typo', 'true');

    $shortcode->add_dependecy('ewo_use_position_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_position_typo', 'template', 'ewo_layout1');
    $shortcode->add_dependecy('ewo_position_typo', 'ewo_use_position_typo', 'true');

    $shortcode->add_params([
        'ewo_use_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for name?', 'ewo'),
            'grid' => 3,
        ],
        'ewo_title_typo' => [
            'type' => 'typography',
            'group' => 'Ewo Name Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__name',
        ],
        'ewo_use_position_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for position?', 'ewo'),
            'grid' => 3,
        ],
        'ewo_position_typo' => [
            'type' => 'typography',
            'group' => 'Ewo Position Typography',
            'settings' => [
                'tag' => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member__position',
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'ewo_',
        'dependency' => ['template', ['ewo_layout1']]
    ]);
}

function ewo_team_member_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ewo_use_title_typo']) && !empty($shortcode->atts['ewo_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__name'], $shortcode->parse_typography($shortcode->atts['ewo_title_typo']));
    }
    if (!empty($shortcode->atts['ewo_use_position_typo']) && !empty($shortcode->atts['ewo_position_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['ewo_position_typo']));
    }

    return $css;
}

add_filter('aheto_team_member_dynamic_css', 'ewo_team_member_layout1_dynamic_css', 10, 2);