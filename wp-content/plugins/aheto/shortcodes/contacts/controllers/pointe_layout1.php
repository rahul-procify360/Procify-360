<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'pointe_contacts_layout1');



/**
 * Contacts
 */

function pointe_contacts_layout1($shortcode)
{
	$preview_dir = '//assets.aheto.co/contacts/previews/';

    $shortcode->add_layout('pointe_layout1', [
        'title' => esc_html__('Pointe contents classic', 'pointe'),
        'image' => $preview_dir . 'pointe_layout1.jpg',
    ]);

	aheto_demos_add_dependency( ['use_heading', 't_heading'], [ 'pointe_layout1'], $shortcode );

	$shortcode->add_dependecy('pointe_contacts_group', 'template', 'pointe_layout1');

    $shortcode->add_dependecy('pointe_use_content_typo', 'template',  'pointe_layout1');
    $shortcode->add_dependecy('pointe_content_typo', 'template',  'pointe_layout1');
    $shortcode->add_dependecy('pointe_content_typo', 'pointe_use_content_typo', 'true');

	$shortcode->add_params([

		'pointe_contacts_group' => [
            'type'    => 'group',
            'heading' => esc_html__('Pointe Contacts', 'pointe'),
            'params'  => [
                'pointe_heading_tag' => [
                    'type'    => 'select',
                    'heading' => esc_html__('Element tag for Heading', 'pointe'),
                    'options' => [
                        'h1'  => 'h1',
                        'h2'  => 'h2',
                        'h3'  => 'h3',
                        'h4'  => 'h4',
                        'h5'  => 'h5',
                        'h6'  => 'h6',
                        'p'   => 'p',
                        'div' => 'div',
                    ],
                    'default' => 'h4',
                    'grid'    => 5,
                ],
                'pointe_heading' => [
                    'type'    => 'text',
                    'heading' => esc_html__('Heading', 'pointe'),
                ],
                'pointe_address' => [
                    'type'    => 'textarea',
                    'heading' => esc_html__('Address', 'pointe'),
                ],
                'pointe_phone'   => [
                    'type'    => 'text',
                    'heading' => esc_html__('Phone', 'pointe'),
                ],

                'pointe_email' => [
                    'type'    => 'text',
                    'heading' => esc_html__('Email', 'pointe'),
                ],
            ]
        ],
        'pointe_use_content_typo'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Use contents content typography?', 'pointe'),
            'grid'      => 4,
        ],
        'pointe_content_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe content Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contact p,{{WRAPPER}} .aheto-contact__mail,{{WRAPPER}} .aheto-contact__tel,{{WRAPPER}} .aheto-contact__info',
        ]
	
	]);
	\Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add address icon?', 'pointe'),
        'prefix' => 'pointe_address_',
        'exclude' => ['align'],
        'dependency' => ['template', 'pointe_layout1']
    ]);
   
    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add phone icon?', 'pointe'),
        'prefix' => 'pointe_phone_',
        'exclude' => ['align'],
        'dependency' => ['template', 'pointe_layout1']
    ]);
    
    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add e-mail icon?', 'pointe'),
        'prefix' => 'pointe_email_',
        'exclude' => ['align'],
        'dependency' => ['template', 'pointe_layout1']
    ]);

    \Aheto\Params::add_button_params($shortcode, [
        'prefix' => 'pointe_main_',
        'icons'      => true,
    ], 'pointe_contacts_group');

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix'         => 'pointe_contacts_',
        'include'        => ['arrows', 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch', 'arrows_size'],
        'dependency'     => ['template', ['pointe_layout1']]
    ]);
}

function pointe_contacts_layout1_dynamic_css($css, $shortcode)
{
	if (!empty($shortcode->atts['pointe_use_content_typo']) && !empty($shortcode->atts['pointe_content_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-contact p,%1$s .aheto-contact__mail,%1$s .aheto-contact__tel,%1$s .aheto-contact__info'], $shortcode->parse_typography($shortcode->atts['pointe_content_typo']));
    }

    if ( !empty($shortcode->atts['pointe_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['cs_arrows_size'] );
	}
	
	return $css;
}

add_filter('aheto_contacts_dynamic_css', 'pointe_contacts_layout1_dynamic_css', 10, 2);
