<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contacts_register', 'rela_contacts_layout1');


/**
 * Contacts Shortcode
 */
function rela_contacts_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/contacts/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Contacts 18', 'rela'),
        'image' => $preview_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_light_arrows', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_contacts_group', 'template', 'rela_layout1');

    $shortcode->add_dependecy('rela_use_content_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_content_typo', 'template', 'rela_layout1');
    $shortcode->add_dependecy('rela_content_typo', 'rela_use_content_typo', 'true');

    aheto_demos_add_dependency(['use_heading', 't_heading'], ['rela_layout1'], $shortcode );

    $shortcode->add_params([
        'rela_use_content_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for Content?', 'rela'),
            'grid' => 12,
            'default' => '',
        ],
        'rela_content_typo' => [
            'type' => 'typography',
            'group' => 'Content Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contact__info p, .aheto-contact__info a',
        ],
        'rela_light_arrows' => [
            'type' => 'switch',
            'heading' => esc_html__('Tur on light arrows?', 'rela'),
            'grid' => 12,
        ],
        'rela_contacts_group' => [
            'type' => 'group',
            'heading' => esc_html__('Contacts Items', 'rela'),
            'params' => [
                'rela_heading_tag' => [
                    'type' => 'select',
                    'heading' => esc_html__('Element tag for Heading', 'rela'),
                    'options' => [
                        'h1' => 'h1',
                        'h2' => 'h2',
                        'h3' => 'h3',
                        'h4' => 'h4',
                        'h5' => 'h5',
                        'h6' => 'h6',
                        'p' => 'p',
                        'div' => 'div',
                    ],
                    'default' => 'h4',
                    'grid' => 5,
                ],
                'rela_heading' => [
                    'type' => 'text',
                    'heading' => esc_html__('Heading', 'rela'),
                ],
                'rela_address' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Address', 'rela'),
                ],
                'rela_phone' => [
                    'type' => 'text',
                    'heading' => esc_html__('Phone', 'rela'),
                ],
                'rela_email' => [
                    'type' => 'text',
                    'heading' => esc_html__('Email', 'rela'),
                ]
            ]
        ],
    ]);

    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add address icon?', 'rela'),
        'prefix' => 'rela_address_',
        'exclude' => ['align'],
        'dependency' => ['template', 'rela_layout1']
    ]);
    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add phone icon?', 'rela'),
        'prefix' => 'rela_phone_',
        'exclude' => ['align'],
        'dependency' => ['template', 'rela_layout1']
    ]);
    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'add_label' => esc_html__('Add email icon?', 'rela'),
        'prefix' => 'rela_email_',
        'exclude' => ['align'],
        'dependency' => ['template', 'rela_layout1']
    ]);

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'rela_contacts_',
        'include' => ['arrows', 'loop', 'autoplay', 'speed', 'simulate_touch', 'arrows_size'],
        'dependency' => ['template', ['rela_layout1']]
    ]);
}

function rela_contacts_layout1_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['rela_use_content_typo']) && !empty($shortcode->atts['rela_content_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-contact__info p, %1$s .aheto-contact__info a '], $shortcode->parse_typography($shortcode->atts['rela_content_typo']));
    }
    if ( !empty($shortcode->atts['rela_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['rela_arrows_size'] );
    }
    return $css;
}

add_filter('aheto_contacts_dynamic_css', 'rela_contacts_layout1_dynamic_css', 10, 2);