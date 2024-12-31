<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_testimonials_register', 'pointe_testimonials_layout2' );

/**
 * Testimonials
 */

function pointe_testimonials_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/testimonials/previews/';
    
    $shortcode->add_layout('pointe_layout2', [
        'title' => esc_html__('Pointe Expert', 'pointe'),
        'image' => $preview_dir . 'pointe_layout2.jpg',
    ]);

	$shortcode->add_dependecy('pointe_testimonials_minimal', 'template', 'pointe_layout2');

    $shortcode->add_dependecy('use_pointe_text_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_text_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_text_typo', 'use_pointe_text_typo', 'true');

    $shortcode->add_dependecy('use_pointe_name_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_name_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_name_typo', 'use_pointe_name_typo', 'true');

    $shortcode->add_dependecy('use_pointe_position_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_position_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_position_typo', 'use_pointe_position_typo', 'true');

	$shortcode->add_params( [

		'pointe_testimonials_minimal' => [
            'type'    => 'group',
            'heading' => esc_html__('Testimonials Items', 'pointe'),
            'params'  => [
                'pointe_image'        => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Display Image', 'pointe'),
                ],
                'pointe_name'        => [
                    'type'    => 'text',
                    'heading' => esc_html__('Name', 'pointe'),
                    'default' => esc_html__('Author name', 'pointe'),
                ],
                'pointe_company'     => [
                    'type'    => 'text',
                    'heading' => esc_html__('Position', 'pointe'),
                    'default' => esc_html__('Author position', 'pointe'),
                ],
                'pointe_testimonial' => [
                    'type'    => 'textarea',
                    'heading' => esc_html__('Testimonial', 'pointe'),
                    'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'pointe'),
                ],
            ],
        ],
        'use_pointe_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for text?', 'pointe'),
        ],
        'pointe_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Text Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__text',
        ],
        'use_pointe_name_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for name?', 'pointe'),
        ],
        'pointe_name_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Name Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__name',
        ],
        'use_pointe_position_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for position?', 'pointe'),
        ],
        'pointe_position_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Position Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-tm__position',
        ]
	] );


	  \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix'         => 'pointe_swiper_',
        'include'        => ['loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows'],
        'dependency'     => ['template', ['pointe_layout2']]
    ]);
}
function pointe_testimonials_layout2_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['use_pointe_text_typo']) && !empty($shortcode->atts['pointe_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
    }
    if (!empty($shortcode->atts['use_pointe_name_typo']) && !empty($shortcode->atts['pointe_name_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['pointe_name_typo']));
    }
    if (!empty($shortcode->atts['use_pointe_position_typo']) && !empty($shortcode->atts['pointe_position_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['pointe_position_typo']));
    }
    return $css;
}

add_filter('aheto_team_member_dynamic_css', 'pointe_testimonials_layout2_dynamic_css', 10, 2);