<?php

use Aheto\Helper;

add_action('aheto_before_aheto_pricing-tables_register', 'rela_pricing_tables_layout5');


/**
 * Pricing Tables Shortcode
 */
function rela_pricing_tables_layout5($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/pricing-tables/previews/';

    $shortcode->add_layout('rela_layout5', [
        'title' => esc_html__('Pricing Tables 26', 'rela'),
        'image' => $shortcode_dir . 'rela_layout5.jpg',
    ]);

    $shortcode->add_dependecy('rela_pricings', 'template', 'rela_layout5');

    $shortcode->add_dependecy('rela_use_label_typo', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_label_typo', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_label_typo', 'rela_use_label_typo', 'true');

    $shortcode->add_dependecy('rela_remove_box_shadow', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_add_border', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_remove_icons', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_list_title_bg', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_use_list_title_typo', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_list_title_typo', 'template', 'rela_layout5');
    $shortcode->add_dependecy('rela_list_title_typo', 'rela_use_list_title_typo', 'true');

    $shortcode->add_params([
        'rela_use_list_title_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for list title?', 'rela'),
            'grid' => 3,
        ],
        'rela_list_title_typo' => [
            'type' => 'typography',
            'group' => 'Rela List Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__list-link',
        ],
        'rela_use_label_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for label?', 'rela'),
            'grid' => 3,
        ],
        'rela_label_typo' => [
            'type' => 'typography',
            'group' => 'Rela Label Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__box-title span',
        ],
        'rela_remove_icons' => [
	        'type' => 'switch',
	        'heading' => esc_html__('Remove icon from Active List Title?', 'rela'),
	        'grid' => 3,
        ],
        'rela_list_title_bg' => [
	        'type' => 'switch',
	        'heading' => esc_html__('Add background for Active List Title?', 'rela'),
	        'grid' => 3,
        ],
        'rela_remove_box_shadow' => [
	        'type' => 'switch',
	        'heading' => esc_html__('Remove box shadow for Items?', 'rela'),
	        'grid' => 3,
        ],
        'rela_add_border' => [
	        'type' => 'switch',
	        'heading' => esc_html__('Add border for Items?', 'rela'),
	        'grid' => 3,
        ],
        'rela_pricings' => [
            'type' => 'group',
            'heading' => esc_html__('Rela Consult Pricing Items', 'rela'),
            'params' => [
                'rela_pricings_heading' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category', 'rela'),
                    'default' => esc_html__('Put your text...', 'rela'),
                ],
                'rela_pricings_title' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category heading', 'rela'),
                    'default' => esc_html__('Put your text...', 'rela'),
                ],
                'rela_pricings_label' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category label', 'rela'),
                    'default' => esc_html__('', 'rela'),
                ],
                'rela_pricings_price' => [
                    'type' => 'text',
                    'heading' => esc_html__('Category price', 'rela'),
                    'default' => esc_html__('Put your text...', 'rela'),
                ],
                'rela_pricings_descr' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Category description', 'rela'),
                    'default' => esc_html__('Put your text...', 'rela'),
                ],
            ],
        ],
    ]);


	\Aheto\Params::add_button_params( $shortcode, [
		'group'      => esc_html__( 'Rela Button Settings', 'rela' ),
		'prefix' => 'rela_pricing_',
	], 'rela_pricings' );

}

function rela_pricing_tables_layout5_dynamic_css($css, $shortcode)
{
    if ( ! empty( $shortcode->atts['rela_use_list_title_typo'] ) && ! empty( $shortcode->atts['rela_list_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-pricing__list-link'], $shortcode->parse_typography( $shortcode->atts['rela_list_title_typo'] ) );
    }
    if (!empty($shortcode->atts['rela_use_label_typo']) && !empty($shortcode->atts['rela_label_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__box-title span'], $shortcode->parse_typography($shortcode->atts['rela_label_typo']));
    }
    return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'rela_pricing_tables_layout5_dynamic_css', 10, 2);