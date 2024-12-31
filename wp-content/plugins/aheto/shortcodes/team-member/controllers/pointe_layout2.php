<?php

use Aheto\Helper;

add_action('aheto_before_aheto_team-member_register', 'pointe_team_member_layout2');
/**
 * Team Member
 */

function pointe_team_member_layout2($shortcode)
{
    $dir = '//assets.aheto.co/team-member/previews/';

    $shortcode->add_layout('pointe_layout2', [
        'title' => esc_html__('Pointe Team Slider', 'pointe'),
        'image' => $dir . 'pointe_layout2.jpg',
    ]);

    $shortcode->add_dependecy('pointe_use_title_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_title_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_title_typo', 'pointe_use_title_typo', 'true');

    $shortcode->add_dependecy('pointe_use_pointe_subtitle_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_pointe_subtitle_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_pointe_subtitle_typo', 'pointe_use_pointe_subtitle_typo', 'true');

    $shortcode->add_dependecy('pointe_use_dec_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_dec_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_dec_typo', 'pointe_use_dec_typo', 'true');

    $shortcode->add_dependecy('use_pointe_social_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_social_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_social_typo', 'use_pointe_social_typo', 'true');
    
    $shortcode->add_dependecy('pointe_slider', 'template', 'pointe_layout2');

    $shortcode->add_params([
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
        'pointe_use_pointe_subtitle_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for subtitle?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_pointe_subtitle_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Subtitle Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member-content-text__subtitle',
        ],
        'pointe_use_dec_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_dec_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member-content-text__description',
        ],
        'use_pointe_social_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for networks?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_social_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Networks Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-team-member-content__social--link',
        ],
        'pointe_slider'               => [
            'type'    => 'group',
            'heading' => esc_html__('Pointe Slider Items', 'pointe'),
            'params'  => [
                'pointe_image'        => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Main Image', 'pointe'),
                ],
                'pointe_subtitle'        => [
                    'type'    => 'text',
                    'heading' => esc_html__('Subtitle', 'pointe'),
                ],
                'pointe_name'        => [
                    'type'    => 'text',
                    'heading' => esc_html__('Name', 'pointe'),
                ],
                'pointe_dec'        => [
                    'type'    => 'textarea',
                    'heading' => esc_html__('Description', 'pointe'),
                ],
                'pointe_image_slide'        => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Slide Image', 'pointe'),
                ],
                'pointe_signature'        => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Signature', 'pointe'),
                ],
                'font_icon'      => [
                    'type'    => 'select',
                    'heading' => esc_html__('Icon library', 'pointe'),
                    'options' => [
                        'ionicons' => esc_html__('Ionicons', 'pointe'),
                        'elegant'   => esc_html__('Elegant', 'pointe'),
                    ],
                    'default' => 'elegant',
                ],

            ],
        ],
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'pointe_',
        'dependency' => ['template', ['pointe_layout2']]
    ]);
}

function pointe_team_member_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['pointe_use_title_typo']) && !empty($shortcode->atts['pointe_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__name, %1$s .aheto-team-member-content-text__title'], $shortcode->parse_typography($shortcode->atts['pointe_title_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_position_typo']) && !empty($shortcode->atts['pointe_position_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['pointe_position_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_pointe_subtitle_typo']) && !empty($shortcode->atts['pointe_pointe_subtitle_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['pointe_pointe_subtitle_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_dec_typo']) && !empty($shortcode->atts['pointe_dec_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['pointe_dec_typo']));
    }
    if (!empty($shortcode->atts['use_pointe_social_typo']) && !empty($shortcode->atts['pointe_social_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-team-member__position'], $shortcode->parse_typography($shortcode->atts['pointe_social_typo']));
    }

    return $css;
}

add_filter('aheto_team_member_dynamic_css', 'pointe_team_member_layout2_dynamic_css', 10, 2);
