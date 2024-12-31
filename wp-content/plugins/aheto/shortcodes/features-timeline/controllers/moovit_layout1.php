<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-timeline_register', 'moovit_features_timeline_layout1');


/**
 * Features Timeline Shortcode
 */

function moovit_features_timeline_layout1($shortcode)
{
    $dir = '//assets.aheto.co/features-timeline/previews/';

    $shortcode->add_layout('moovit_layout1', [
        'title' => esc_html__('Features Timeline 4', 'moovit'),
        'image' => $dir . 'acacio_layout1.jpg',
    ]);

    $shortcode->add_dependecy('moovit_timeline', 'template', 'moovit_layout1');
    $shortcode->add_dependecy('moovit_filling_color', 'template', 'moovit_layout1');
    $shortcode->add_dependecy('moovit_dark_version', 'template', 'moovit_layout1');
    $shortcode->add_dependecy('moovit_dot_color', 'moovit_use_dot', 'true');


    $shortcode->add_params([
        'moovit_timeline' => [
            'type' => 'group',
            'heading' => esc_html__('Items', 'moovit'),
            'params' => [
                'moovit_timeline_date' => [
                    'type' => 'text',
                    'heading' => esc_html__('Date', 'moovit'),
                ],
                'moovit_timeline_title' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Title', 'moovit'),
                    'description' => esc_html__('To Hightlight text insert text between: [[ Your Text Here ]]', 'moovit'),
                    'default' => esc_html__('Title with [[ hightlight ]] text.', 'moovit'),
                ],
                'moovit_use_dot' => [
                    'type' => 'switch',
                    'heading' => esc_html__('Use dot at the end of the title?', 'moovit'),
                    'grid' => 12,
                ],
                'moovit_dot_color' => [
                    'type' => 'select',
                    'heading' => esc_html__('Color for dot', 'moovit'),
                    'options' => [
                        'primary' => esc_html__('Primary', 'moovit'),
                        'dark' => esc_html__('Dark', 'moovit'),
                        'white' => esc_html__('White', 'moovit'),
                    ],
                    'default' => 'primary',
                ],
                'moovit_timeline_content' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Content', 'moovit'),
                    'default' => esc_html__('Add some text for content', 'moovit'),
                ],
                'moovit_timeline_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Add image', 'moovit'),
                ],
            ],
        ],
        'moovit_filling_color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Filling color for timeline', 'outsourceo'),
            'grid' => 6,
            'selectors' => [
                '{{WRAPPER}} .aheto-timeline__filling-line' => 'background-color: {{VALUE}}',
                '{{WRAPPER}} .aheto-timeline--moovit-modern .aheto-timeline__events a.older-event::after' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                '{{WRAPPER}} .aheto-timeline--moovit-modern .aheto-timeline__events a.selected::after' => 'background-color: {{VALUE}}; border-color: {{VALUE}}',
                '{{WRAPPER}} .aheto-timeline--moovit-modern .aheto-timeline__events a.older-event h5' => 'color: {{VALUE}}',
                '{{WRAPPER}} .aheto-timeline--moovit-modern .aheto-timeline__events a.selected h5' => 'color: {{VALUE}}',

            ],
        ],
        'moovit_dark_version' => [
            'type' => 'switch',
            'heading' => esc_html__('Enable light version?', 'moovit'),
            'grid' => 3,
        ],


    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'moovit_',
        'icons' => true,
    ], 'moovit_timeline');

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'moovit_',
        'dependency' => ['template', ['moovit_layout1']]
    ]);
}

function moovit_features_timeline_layout1_dynamic_css($css, $shortcode){

    if (isset($shortcode->atts['moovit_filling_color']) && !empty($shortcode->atts['moovit_filling_color'])) {
        $color = Sanitize::color($shortcode->atts['moovit_filling_color']);
        $css['global']['%1$s .aheto-timeline--moovit-modern .aheto-timeline__events a.older-event::after']['background-color'] = $color;
        $css['global']['%1$s .aheto-timeline--moovit-modern .aheto-timeline__events a.older-event::after']['border-color'] = $color;
        $css['global']['%1$s .aheto-timeline--moovit-modern .aheto-timeline__events a.selected::after']['background-color'] = $color;
        $css['global']['%1$s .aheto-timeline--moovit-modern .aheto-timeline__events a.selected::after']['border-color'] = $color;
        $css['global']['%1$s .aheto-timeline--moovit-modern .aheto-timeline__events a.older-event h5']['color'] = $color;
        $css['global']['%1$s .aheto-timeline--moovit-modern .aheto-timeline__events a.selected h5']['color'] = $color;
    }

    return $css;
}

add_filter('aheto_features_timeline_dynamic_css', 'moovit_features_timeline_layout1_dynamic_css', 10, 2);