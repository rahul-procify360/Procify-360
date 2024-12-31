<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_pricing-tables_register', 'pointe_pricing_tables_layout2' );


/**
 * Pricing Tables Shortcode
 */

function pointe_pricing_tables_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/pricing-tables/previews/';

	$shortcode->add_layout( 'pointe_layout2', [
		'title' => esc_html__( 'Pointe Side', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout2.jpg',
	] );

	aheto_demos_add_dependency(['price', 'features'], ['pointe_layout2'], $shortcode);
	
	$shortcode->add_dependecy('pointe_heading', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_active', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_background', 'template', 'pointe_layout2');

    $shortcode->add_dependecy('pointe_use_heading_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_heading_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_heading_typo', 'pointe_use_heading_typo', 'true');


    $shortcode->add_dependecy('pointe_use_item_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_item_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_item_typo', 'pointe_use_item_typo', 'true');

    $shortcode->add_dependecy('pointe_use_value_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_value_typo', 'template', ['pointe_layout2']);
    $shortcode->add_dependecy('pointe_value_typo', 'pointe_use_value_typo', 'true');

	$shortcode->add_params( [
		'pointe_heading'      => [
            'type'        => 'text',
            'heading'     => esc_html__('Heading', 'pointe'),
            'description' => esc_html__('To Hightlight text insert text between: [[ Your Text Here ]]', 'pointe'),
            'default'     => esc_html__('Heading with [[ hightlight ]] text.', 'pointe'),
            'admin_label' => true,
		],
		'pointe_active'       => [
            'type'    => 'switch',
            'heading' => esc_html__('Mark as active?', 'pointe'),
            'grid'    => 12,
		],
		'pointe_background'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__('Background color', 'pointe'),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .aheto-pricing--pointe-classic' => 'background: {{VALUE}}',
            ],
        ],
		'pointe_use_heading_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Heading?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_heading_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Heading Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__title',
		],
		'pointe_use_item_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Item?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_item_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Item Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__list-item',
		],

		'pointe_use_value_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Price?', 'pointe'),
        ],
        'pointe_value_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Price Typography',
            'settings' => [
				'tag'        => false,
				'text_align' => false
            ],
            'selector' => '{{WRAPPER}} .aheto-pricing__cost-value',
		]
	] );

	\Aheto\Params::add_button_params($shortcode, [
        'prefix'     => 'pointe_',
        'dependency' => ['template', 'pointe_layout2']
    ]);
}
function pointe_pricing_tables_layout2_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_background'])) {
        $color                               = Sanitize::color($shortcode->atts['pointe_background']);
        $css['global']['%1$s']['background'] = $color;
    }
    if (!empty($shortcode->atts['pointe_use_heading_typo']) && !empty($shortcode->atts['pointe_heading_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__title'], $shortcode->parse_typography($shortcode->atts['pointe_heading_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_item_typo']) && !empty($shortcode->atts['pointe_item_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__list-item'], $shortcode->parse_typography($shortcode->atts['pointe_item_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_value_typo']) && !empty($shortcode->atts['pointe_value_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-pricing__cost-value'], $shortcode->parse_typography($shortcode->atts['pointe_value_typo']));
    }

	return $css;
}

add_filter('aheto_pricing_tables_dynamic_css', 'pointe_pricing_tables_layout2_dynamic_css', 10, 2);

