<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'rela_pricing_tables_layout1');


/**
 * Pricing Tables Shortcode
 */
function rela_pricing_tables_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Pricing Tables 22', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_features', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_active', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_heading', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_price_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_price_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_price_typo', 'rela_use_price_typo', 'true');

    $shortcode->add_dependecy('rela_use_time_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_time_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_time_typo', 'rela_use_time_typo', 'true');

    aheto_demos_add_dependency(['price', 'description'], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_use_time_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'rela'),
            'grid' => 3,
        ],
        'rela_time_typo' => [
            'type' => 'typography',
            'group' => 'Rela Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__cost-time',
        ],
        'rela_heading' => [
            'type' => 'text',
            'heading' => esc_html__('Heading', 'rela'),
            'default' => esc_html__('Heading text.', 'rela'),
            'admin_label' => true,
        ],
        'rela_active' => [
            'type' => 'switch',
            'heading' => esc_html__('Mark as active?', 'rela'),
            'grid' => 12,
        ],
        'rela_use_price_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for price?', 'rela'),
            'grid' => 3,
        ],
        'rela_price_typo' => [
            'type' => 'typography',
            'group' => 'Rela Price Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
        ],
        'rela_features' => [
            'type' => 'group',
            'heading' => esc_html__('Features', 'rela'),
            'params' => [
                'rela_feature' => [
                    'type' => 'text',
                    'heading' => esc_html__('Feature', 'rela'),
                ],
                'rela_mark' => [
                    'type' => 'select',
                    'heading' => esc_html__('Decoration', 'rela'),
                    'default' => 'default',
                    'options' => [
                        'default' => esc_html__('Default', 'rela'),
                        'line-through' => esc_html__('Line-through', 'rela'),
                        'opacity' => esc_html__('Opacity', 'rela'),
                    ],
                ],
                'rela_resp_descr' => [
                    'type' => 'text',
                    'heading' => esc_html__('Description for tablets and mobiles', 'rela'),
                ],
            ],
        ],
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'add_button' => true,
        'prefix' => 'rela_',
        'dependency' => ['template', 'rela_layout1']
    ]);
}

function rela_pricing_tables_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_price_typo']) && !empty($shortcode->atts['rela_price_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography($shortcode->atts['rela_price_typo']));
    }
    if (!empty($shortcode->atts['rela_use_time_typo']) && !empty($shortcode->atts['rela_time_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__cost-time'], $shortcode->parse_typography($shortcode->atts['rela_time_typo']));
    }
    return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'rela_pricing_tables_layout1_dynamic_css', 10, 2);