<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'rela_features_single_layout4');


/**
 * Features Single Shortcode
 */
function rela_features_single_layout4($shortcode)
{

    $preview_dir = '//assets.aheto.co/features-single/previews/';

    $shortcode->add_layout('rela_layout4', [
        'title' => esc_html__('Features Single 47', 'rela'),
        'image' => $preview_dir . 'rela_layout4.jpg',
    ]);

    $shortcode->add_dependecy('rela_use_title_typo', 'template', 'rela_layout4');
    $shortcode->add_dependecy('rela_title_typo', 'template', 'rela_layout4');
    $shortcode->add_dependecy('rela_title_typo', 'rela_use_title_typo', 'true');

    $shortcode->add_dependecy('rela_use_description_typo', 'template', 'rela_layout4');
    $shortcode->add_dependecy('rela_description_typo', 'template', 'rela_layout4');
    $shortcode->add_dependecy('rela_description_typo', 'rela_use_description_typo', 'true');

    $shortcode->add_dependecy('rela_border-color', 'template', 'rela_layout4');
    $shortcode->add_dependecy('rela_price', 'template', 'rela_layout4');
    $shortcode->add_dependecy('rela_hover-color', 'template', 'rela_layout4');

    aheto_demos_add_dependency(['s_image', 's_heading', 's_description', 'button'], ['rela_layout4'], $shortcode);

    $shortcode->add_params([
        'rela_price' => [
            'type' => 'text',
            'heading' => esc_html__('Price', 'rela'),
        ],
        'rela_hover-color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Hover color', 'rela'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-features-block__overlay' => 'background-color: {{VALUE}}']
        ],
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
        'rela_border-color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Border color', 'rela'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-features-block__image:before' => 'border-color: {{VALUE}}']
        ],
    ]);


    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'rela_',
        'icons' => true,
        'dependency' => ['template', 'rela_layout4']
    ]);

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix' => 'rela_',
        'dependency' => ['template', ['rela_layout4']]
    ]);

}

function rela_features_single_layout4_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_title_typo']) && !empty($shortcode->atts['rela_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-block__title'], $shortcode->parse_typography($shortcode->atts['rela_title_typo']));
    }

    if (!empty($shortcode->atts['rela_use_description_typo']) && !empty($shortcode->atts['rela_description_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-block__description'], $shortcode->parse_typography($shortcode->atts['rela_description_typo']));
    }

    if (!empty($shortcode->atts['rela_hover-color'])) {
        $color = Sanitize::color($shortcode->atts['rela_hover-color']);
        $css['global']['%1$s .aheto-features-block__overlay']['background-color'] = $color;
    }

    if (!empty($shortcode->atts['rela_border-color'])) {
        $color = Sanitize::color($shortcode->atts['rela_border-color']);
        $css['global']['%1$s .aheto-features-block__image']['border-color'] = $color;
    }

    return $css;
}

add_filter('aheto_features_single_dynamic_css', 'rela_features_single_layout4_dynamic_css', 10, 2);

