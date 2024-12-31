<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'rela_features_single_layout2');


/**
 * Features Single Shortcode
 */
function rela_features_single_layout2($shortcode)
{

    $preview_dir = '//assets.aheto.co/features-single/previews/';


    $shortcode->add_layout('rela_layout2', [
        'title' => esc_html__('Features Single 45', 'rela'),
        'image' => $preview_dir . 'rela_layout2.jpg',
    ]);


    $shortcode->add_dependecy('rela_use_title_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_title_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_title_typo', 'rela_use_title_typo', 'true');

    $shortcode->add_dependecy('rela_use_description_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_description_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_description_typo', 'rela_use_description_typo', 'true');

    $shortcode->add_dependecy('rela_background-color', 'template', 'rela_layout2');

    aheto_demos_add_dependency(['s_image', 's_heading', 's_description'], ['rela_layout2'], $shortcode);

    $shortcode->add_params([
        'rela_use_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_title_typo' => [
            'type' => 'typography',
            'group' => 'Heading Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-block__title',
        ],
        'rela_use_description_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_description_typo' => [
            'type' => 'typography',
            'group' => 'Rela Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-features-block__description',
        ],
        'rela_background-color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Background color', 'rela'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-features-block__image-wrap' => 'background-color: {{VALUE}}']
        ],
    ]);


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_',
        'dependency' => ['template', ['rela_layout2']]
    ]);

}

function rela_features_single_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_title_typo']) && !empty($shortcode->atts['rela_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-block__title'], $shortcode->parse_typography($shortcode->atts['rela_title_typo']));
    }

    if (!empty($shortcode->atts['rela_use_description_typo']) && !empty($shortcode->atts['rela_description_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-block__description'], $shortcode->parse_typography($shortcode->atts['rela_description_typo']));
    }

    if (!empty($shortcode->atts['rela_background-color'])) {
        $color = Sanitize::color($shortcode->atts['rela_background-color']);
        $css['global']['%1$s .aheto-features-block__image-wrap']['background-color'] = $color;
    }
    return $css;
}

add_filter('aheto_features_single_dynamic_css', 'rela_features_single_layout2_dynamic_css', 10, 2);

