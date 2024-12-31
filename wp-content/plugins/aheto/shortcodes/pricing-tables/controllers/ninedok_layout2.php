<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'ninedok_pricing_tables_layout2');


/**
 * Pricing Tables Shortcode
 */

function ninedok_pricing_tables_layout2($shortcode)
{

    $preview_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout('ninedok_layout2', [
        'title' => esc_html__('Pricing Tables 18', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout2.jpg',
    ]);


    $shortcode->add_dependecy('ninedok_pricings', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_box_shadow', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_background_pricing', 'template', 'ninedok_layout2');

    $shortcode->add_dependecy('ninedok_use_lable_typo', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_lable_typo', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_lable_typo', 'ninedok_use_lable_typo', 'true');

    $shortcode->add_dependecy('ninedok_use_category_typo', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_category_typo', 'template', 'ninedok_layout2');
    $shortcode->add_dependecy('ninedok_category_typo', 'ninedok_use_category_typo', 'true');

    $shortcode->add_params([
        'ninedok_box_shadow' => [
            'type' => 'switch',
            'heading' => esc_html__('Enable box shadow?', 'ninedok'),
            'grid' => 3,
        ],
        'ninedok_pricings' => [
            'type' => 'group',
            'heading' => esc_html__('Ninedok Pricing Items', 'ninedok'),
            'params' => [
                'ninedok_pricings_heading' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category', 'ninedok'),
                    'default' => esc_html__('Put your text...', 'ninedok'),
                ],
                'ninedok_pricings_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category heading', 'ninedok'),
                    'default' => esc_html__('Put your text...', 'ninedok'),
                ],
                'ninedok_pricings_label' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category label', 'ninedok'),
                    'default' => esc_html__('', 'ninedok'),
                ],
                'ninedok_pricings_price' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category price', 'ninedok'),
                    'default' => esc_html__('Put your text...', 'ninedok'),
                ],
                'ninedok_pricings_descr' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Category description', 'ninedok'),
                    'default' => esc_html__('Put your text...', 'ninedok'),
                ],


            ],
        ],
        'ninedok_background_pricing' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Background color pricing', 'ninedok'),
            'grid' => 6,
            'default' => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-pricing__box' => 'background: {{VALUE}}',
            ],
        ],
        'ninedok_use_lable_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for label?', 'ninedok'),
            'grid' => 12,
        ],
        'ninedok_lable_typo' => [
            'type' => 'typography',
            'group' => 'Ninedok Label Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__box-title span ',
        ],
        'ninedok_use_category_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for category?', 'ninedok'),
            'grid' => 12,
        ],
        'ninedok_category_typo' => [
            'type' => 'typography',
            'group' => 'Ninedok Category Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__list-item a',
        ],


    ]);

}

function ninedok_pricing_tables_layout2_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ninedok_background_pricing'])) {
        $color = Sanitize::color($shortcode->atts['ninedok_background_pricing']);
        $css['global']['%1$s .aheto-pricing__box']['color'] = $color;
    }
    if (!empty($shortcode->atts['ninedok_use_lable_typo']) && !empty($shortcode->atts['ninedok_lable_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__box-title span'], $shortcode->parse_typography($shortcode->atts['ninedok_lable_typo']));
    }
    if (!empty($shortcode->atts['ninedok_use_category_typo']) && !empty($shortcode->atts['ninedok_category_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__list-item a'], $shortcode->parse_typography($shortcode->atts['ninedok_category_typo']));
    }
    return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'ninedok_pricing_tables_layout2_dynamic_css', 10, 2);