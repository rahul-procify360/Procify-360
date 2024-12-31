<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'rela_pricing_tables_layout3');


/**
 * Pricing Tables Shortcode
 */
function rela_pricing_tables_layout3($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout('rela_layout3', [
        'title' => esc_html__('Pricing Tables 24', 'rela'),
        'image' => $shortcode_dir . 'rela_layout3.jpg',
    ]);

    $shortcode->add_dependecy('rela_special_color', 'template', 'rela_layout3');
    $shortcode->add_dependecy('rela_min_price', 'template', 'rela_layout3');

    $shortcode->add_dependecy('rela_use_spec_typo', 'template', 'rela_layout3');
    $shortcode->add_dependecy('rela_spec_typo', 'template', 'rela_layout3');
    $shortcode->add_dependecy('rela_spec_typo', 'rela_use_spec_typo', 'true');

    $shortcode->add_params([
        'rela_use_spec_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for special?', 'rela'),
            'grid' => 3,
        ],
        'rela_spec_typo' => [
            'type' => 'typography',
            'group' => 'Rela Special Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__special',
        ],
        'rela_min_price' => [
            'type' => 'group',
            'heading' => esc_html__('Item', 'rela'),
            'params' => [
                'rela_time' => [
                    'type' => 'text',
                    'heading' => esc_html__('Heading', 'rela'),
                ],
                'rela_special' => [
                    'type' => 'text',
                    'heading' => esc_html__('Special', 'rela'),
                ],
                'rela_price' => [
                    'type' => 'text',
                    'heading' => esc_html__('Price', 'rela'),
                ],
            ],
        ],
        'rela_special_color' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Special color', 'rela'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-pricing__special' => 'color: {{VALUE}}']
        ],

    ]);

}

function rela_pricing_tables_layout3_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['rela_use_spec_typo']) && !empty($shortcode->atts['rela_spec_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__special'], $shortcode->parse_typography($shortcode->atts['rela_spec_typo']));
    }

    if (!empty($shortcode->atts['rela_special_color'])) {
        $color = Sanitize::color($shortcode->atts['rela_special_color']);
        $css['global']['%1$s .aheto-pricing__special']['color'] = $color;
    }

    return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'rela_pricing_tables_layout3_dynamic_css', 10, 2);