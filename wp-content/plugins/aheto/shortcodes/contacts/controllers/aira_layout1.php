<?php

use Aheto\Helper;
use Aheto\Sanitize;


add_action( 'aheto_before_aheto_contacts_register', 'aira_contacts_layout1' );


/**
 * Contacts Shortcode
 */
function aira_contacts_layout1( $shortcode ) {
    $dir = '//assets.aheto.co/contacts/previews/';

    $shortcode->add_layout( 'aira_layout1', [
        'title' => esc_html__( 'Aira Slider', 'aira' ),
        'image' => $dir . 'aira_layout1.jpg',
    ] );

    $shortcode->add_dependecy( 'aira_light_arrows', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_contacts_group', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_use_content_typo', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_icons_size', 'template', 'aira_layout1' );
    $shortcode->add_dependecy( 'aira_content_typo', 'aira_use_content_typo', 'true' );

    aheto_demos_add_dependency(['use_heading', 't_heading'], ['aira_layout1'], $shortcode);

    $shortcode->add_params( [
        'aira_icons_size' => [
            'type'    => 'text',
            'heading' => esc_html__('Icons size', 'aira'),
            'description' => esc_html__( 'Enter icon font size with units.', 'aira' ),
            'grid'        => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-contact__info i:before' => 'font-size: {{VALUE}}'],
        ],
        'aira_use_content_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for content?', 'aira' ),
            'grid'    => 3,
        ],
        'aira_content_typo' => [
            'type'     => 'typography',
            'group'    => 'Content Slider Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-contact--aira-slider p,
                            {{WRAPPER}} .aheto-contact--aira-slider h3,
                            {{WRAPPER}} .aheto-contact__mail,
                            {{WRAPPER}} .aheto-contact__tel,
                            {{WRAPPER}} .aheto-contact__info',
        ],
        'aira_light_arrows'     => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Turn on light arrows?', 'aira' ),
            'grid'    => 12,
        ],
        'aira_contacts_group' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Contacts Items', 'aira' ),
            'params'  => [
                'aira_heading_tag' => [
                    'type'    => 'select',
                    'heading' => esc_html__( 'Element tag for Heading', 'aira' ),
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
                'aira_heading'   => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Heading', 'aira' ),
                ],
                'aira_address'     => [
                    'type'    => 'textarea',
                    'heading' => esc_html__( 'Address', 'aira' ),
                ],
                'aira_phone'       => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Phone', 'aira' ),
                ],
                'aira_email'       => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Email', 'aira' ),
                ]
            ]
        ],

    ] );

    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add address icon?', 'aira' ),
        'prefix'     => 'aira_address_',
        'exclude'    => [ 'align', 'color'],
        'dependency' => [ 'template', ['aira_layout1'] ]
    ]);
    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add phone icon?', 'aira' ),
        'prefix'     => 'aira_phone_',
        'exclude'    => [ 'align', 'color'],
        'dependency' => [ 'template', ['aira_layout1'] ]
    ]);
    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add email icon?', 'aira' ),
        'prefix'     => 'aira_email_',
        'exclude'    => [ 'align', 'color'],
        'dependency' => [ 'template', ['aira_layout1'] ]
    ]);
    \Aheto\Params::add_carousel_params( $shortcode, [
        'custom_options' => true,
        'prefix'         => 'aira_contacts_',
        'include'        => [ 'arrows', 'loop', 'autoplay', 'speed', 'simulate_touch', 'arrows_size' ],
        'dependency'     => [ 'template', [ 'aira_layout1' ] ]
    ] );
}

function aira_contacts_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['aira_use_content_typo'] ) && ! empty( $shortcode->atts['aira_content_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-contact p,
                                                %1$s .aheto-contact h3,
                                                %1$s .aheto-contact__mail,
                                                %1$s .aheto-contact__tel,
                                                %1$s .aheto-contact__info,
                                                '], $shortcode->parse_typography( $shortcode->atts['aira_content_typo'] ) );
    }

    if ( ! empty( $shortcode->atts['aira_icon_space'] ) ) {
        $css['global']['%1$s .aheto-contact__info i']['margin-right'] = Sanitize::size( $shortcode->atts['aira_icon_space'] );
    }
    if ( !empty($shortcode->atts['aira_arrows_size']) ) {
        $css['global']['%1$s .swiper-button-next, %1$s .swiper-button-prev']['font-size'] = Sanitize::size( $shortcode->atts['aira_arrows_size'] );
    }
    return $css;
}
add_filter( 'aheto_contacts_dynamic_css', 'aira_contacts_layout1_dynamic_css', 10, 2 );