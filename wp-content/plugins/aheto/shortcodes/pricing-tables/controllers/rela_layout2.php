<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'rela_pricing_tables_layout2');


/**
 * Pricing Tables Shortcode
 */
function rela_pricing_tables_layout2($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout('rela_layout2', [
        'title' => esc_html__('Pricing Tables 23', 'rela'),
        'image' => $shortcode_dir . 'rela_layout2.jpg',
    ]);

    $shortcode->add_dependecy('rela_heading', 'template', 'rela_layout2');

    $shortcode->add_dependecy('rela_use_price_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_price_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_price_typo', 'rela_use_price_typo', 'true');

    $shortcode->add_dependecy('rela_use_heading_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_heading_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_heading_typo', 'rela_use_heading_typo', 'true');

    $shortcode->add_dependecy('rela_use_description_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_description_typo', 'template', 'rela_layout2');
    $shortcode->add_dependecy('rela_description_typo', 'rela_use_description_typo', 'true');

    aheto_demos_add_dependency(['price', 'description'], ['rela_layout2'], $shortcode);

    $shortcode->add_params([
        'rela_heading' => [
            'type' => 'text',
            'heading' => esc_html__('Heading', 'rela'),
            'default' => esc_html__('Heading text.', 'rela'),
            'admin_label' => true,
        ],
        'rela_use_heading_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'rela'),
            'grid' => 3,
        ],
        'rela_heading_typo' => [
            'type' => 'typography',
            'group' => 'Rela Heading Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__title',
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
        'rela_use_description_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'rela'),
            'grid' => 3,
        ],
        'rela_description_typo' => [
            'type' => 'typography',
            'group' => 'Rela Description Typography',
            'settings' => [
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__description',
        ],
    ]);
}

function rela_pricing_tables_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_use_heading_typo']) && !empty($shortcode->atts['rela_heading_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography($shortcode->atts['rela_heading_typo']));
    }

    if (!empty($shortcode->atts['rela_use_price_typo']) && !empty($shortcode->atts['rela_price_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography($shortcode->atts['rela_price_typo']));
    }

    if (!empty($shortcode->atts['rela_use_description_typo']) && !empty($shortcode->atts['rela_description_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__description'], $shortcode->parse_typography($shortcode->atts['rela_description_typo']));
    }

    return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'rela_pricing_tables_layout2_dynamic_css', 10, 2);