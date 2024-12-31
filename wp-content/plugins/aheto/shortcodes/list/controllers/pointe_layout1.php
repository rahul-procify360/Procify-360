<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'pointe_list_layout1');

/**
 * List
 */

function pointe_list_layout1($shortcode)
{
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout('pointe_layout1', [
		'title' => esc_html__('Pointe Table List', 'pointe'),
		'image' => $dir . 'pointe_layout1.jpg',
	]);

	$shortcode->add_dependecy('pointe_table_lists', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_align', 'template', 'pointe_layout1');

    $shortcode->add_dependecy('use_pointe_text_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_text_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_text_typo', 'use_pointe_text_typo', 'true');
    
    $shortcode->add_dependecy('use_pointe_month_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_month_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_month_typo', 'use_pointe_month_typo', 'true');

    $shortcode->add_dependecy('use_pointe_dec_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_dec_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_dec_typo', 'use_pointe_dec_typo', 'true');

    $shortcode->add_dependecy('use_pointe_paragraph_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_paragraph_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_paragraph_typo', 'use_pointe_paragraph_typo', 'true');
    
    $shortcode->add_dependecy('use_pointe_day_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_dec_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_dec_typo', 'use_pointe_day_typo', 'true');


	$shortcode->add_params([
		'pointe_table_lists'   => [
            'type'    => 'group',
            'heading' => esc_html__('Pointe Table Lists', 'pointe'),
            'params'  => [
                'pointe_first_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__('First Item Text', 'pointe'),
                ],
                'pointe_first_month'  => [
                    'type'    => 'text',
                    'heading' => esc_html__('First Item Month', 'pointe'),
                ],
                'pointe_image'        => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Display Image', 'pointe'),
                ],
                'pointe_second_item' => [
                    'type'    => 'text',
                    'heading' => esc_html__('Second Item Text', 'pointe'),
                ],
                'pointe_first_loc'  => [
                    'type'    => 'text',
                    'heading' => esc_html__('First Item Location', 'pointe'),
                ],
                'pointe_third_item'  => [
                    'type'    => 'text',
                    'heading' => esc_html__('Third Item Text', 'pointe'),
                ],
                'pointe_third_time'  => [
                    'type'    => 'text',
                    'heading' => esc_html__('Third Item Time', 'pointe'),
                ],
                'pointe_third_fourth'  => [
                    'type'    => 'text',
                    'heading' => esc_html__('Third Item Cost', 'pointe'),
                ],
                'pointe_third_val'  => [
                    'type'    => 'text',
                    'heading' => esc_html__('Third Item Value', 'pointe'),
                ],
                'pointe_align_item' => [
                    'type'    => 'select',
                    'heading' => esc_html__('Align for First Item Text', 'pointe'),
                    'options' => [
                        'default' => 'Default',
                        'left'    => 'Left',
                        'center'  => 'Center',
                        'right'   => 'Right',
                    ],
                    'default' => 'default',
                ],
            ],
        ],
        'pointe_align'         => [
            'type'    => 'select',
            'heading' => esc_html__('Align Load Button', 'pointe'),
            'grid'    => 6,
            'options' => \Aheto\Helper::choices_alignment()
        ],
        'use_pointe_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'pointe'),
        ],
        'pointe_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Heading Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-list--column h6',
        ],
        'use_pointe_day_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Day?', 'pointe'),
        ],
        'pointe_day_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Day Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-list--column h3',
        ],
        'use_pointe_month_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Month?', 'pointe'),
        ],
        'pointe_month_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Month Typography',
            'settings' => [
                'tag'        => false,
                'align'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-list--box-date p',
        ],
        'use_pointe_dec_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Decription?', 'pointe'),
        ],
        'pointe_dec_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Description Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-list--column h6',
        ],
        'use_pointe_paragraph_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Paragraph?', 'pointe'),
        ],
        'pointe_paragraph_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Paragraph Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-list--column .pointe_second_item__dec',
        ]
	]);
	\Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'pointe_main_',
    ], 'pointe_table_lists');

    \Aheto\Params::add_button_params($shortcode, [
        'add_label' => esc_html__('Add additional button?', 'pointe'),
        'prefix'    => 'pointe_add_',
    ], 'pointe_table_lists');
}
function pointe_list_layout1_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['use_pointe_text_typo']) && !empty($shortcode->atts['pointe_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-list--column h6'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
    }
    if (!empty($shortcode->atts['use_pointe_month_typo']) && !empty($shortcode->atts['pointe_month_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-list--box-date p'], $shortcode->parse_typography($shortcode->atts['pointe_month_typo']));
    }
    if (!empty($shortcode->atts['use_pointe_day_typo']) && !empty($shortcode->atts['pointe_day_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-list--column h3'], $shortcode->parse_typography($shortcode->atts['pointe_day_typo']));
    }
    if (!empty($shortcode->atts['use_pointe_dec_typo']) && !empty($shortcode->atts['pointe_dec_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-list--column h6'], $shortcode->parse_typography($shortcode->atts['pointe_dec_typo']));
    }
    return $css;
}

add_filter( 'aheto_list_dynamic_css', 'pointe_list_layout1_dynamic_css', 10, 2 );