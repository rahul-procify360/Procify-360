<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-timeline_register', 'rela_features_timeline_layout1');

/**
 * Features Timeline Shortcode
 */
function rela_features_timeline_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/features-timeline/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Features Timeline 6', 'rela'),
        'image' => $preview_dir . 'acacio_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_timeline', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_dark_version', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_arrow_size', 'template', 'rela_layout1');


    $shortcode->add_params([
        'rela_arrow_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Arrow size', 'rela'),
            'description' => esc_html__( 'Enter arrow font size with units.', 'rela' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-timeline__navigation a' => 'font-size: {{VALUE}}'],
        ],
        'rela_timeline' => [
            'type' => 'group',
            'heading' => esc_html__('Items', 'rela'),
            'params' => [
                'rela_timeline_date' => [
                    'type' => 'text',
                    'heading' => esc_html__('Date', 'rela'),
                ],
                'rela_timeline_title' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Title', 'rela'),
                    'description' => esc_html__('To Hightlight text insert text between: [[ Your Text Here ]]', 'rela'),
                    'default' => esc_html__('Title with [[ hightlight ]] text.', 'rela'),
                ],
                'rela_timeline_content' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Content', 'rela'),
                    'default' => esc_html__('Add some text for content', 'rela'),
                ],
                'rela_timeline_image' => [
                    'type' => 'attach_image',
                    'heading' => esc_html__('Add image', 'rela'),
                ],
            ],
        ],

        'rela_dark_version' => [
            'type' => 'switch',
            'heading' => esc_html__('Enable dark version?', 'rela'),
            'grid' => 3,
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'rela_',
        'icons' => true,
    ], 'rela_timeline');

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_',
        'dependency' => ['template', ['rela_layout1']]
    ]);
}

function rela_features_timeline_layout1_dynamic_css($css, $shortcode)
{

    if ( !empty($shortcode->atts['rela_arrow_size']) ) {
        $css['global']['%1$s .aheto-timeline__navigation a']['font-size'] = Sanitize::size( $shortcode->atts['rela_arrow_size'] );
    }

    return $css;
}

add_filter('aheto_features_timeline_dynamic_css', 'rela_features_timeline_layout1_dynamic_css', 10, 2);