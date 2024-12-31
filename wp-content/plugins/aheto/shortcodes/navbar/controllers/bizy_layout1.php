<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'bizy_navbar_layout1');


/**
 * Navbar Shortcode
 */
function bizy_navbar_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/navbar/previews/';

    $shortcode->add_layout('bizy_layout1', [
        'title' => esc_html__('Bizy Simple', 'bizy'),
        'image' => $shortcode_dir . 'bizy_layout1.jpg',
    ]);

    $shortcode->add_dependecy('bizy_links','template', 'bizy_layout1');
    $shortcode->add_dependecy('bizy_links_color','template', 'bizy_layout1');
    $shortcode->add_dependecy('bizy_use_label_typo','template', 'bizy_layout1');
    $shortcode->add_dependecy('bizy_label_typo','template', 'bizy_layout1');
    $shortcode->add_dependecy('bizy_label_typo','bizy_use_label_typo', 'true');
    $shortcode->add_dependecy('bizy_icon_circle','template', 'bizy_layout1');


    $shortcode->add_params([
        'bizy_links' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Links', 'bizy' ),
            'params'  => [
                'bizy_label'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Label', 'bizy' ),
                ],
                'bizy_url'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'URL', 'bizy' ),
                ],
            ],
        ],
        'bizy_icon_circle' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable circle background for icon?', 'bizy' ),
            'grid'    => 6,
        ],
        'bizy_links_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Icons color', 'bizy' ),
            'grid'      => 6,
            'selectors' => [ '{{WRAPPER}} .aheto-navbar--item i' => 'color: {{VALUE}}' ],
        ],
        'bizy_use_label_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for menu?', 'bizy' ),
            'grid'    => 6,
        ],
        'bizy_label_typo' => [
            'type'     => 'typography',
            'group'    => 'Bizy Label Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-navbar--item-label',
        ],
    ]);

    \Aheto\Params::add_icon_params( $shortcode, [
        'add_icon'   => true,
        'add_label'  => esc_html__( 'Add icon?', 'bizy' ),
        'prefix'     => 'bizy_',
        'exclude'    => [ 'align', 'font_size', 'color' ],
    ], 'bizy_links' );


}

function bizy_navbar_layout1_dynamic_css($css, $shortcode){

    if (!empty($shortcode->atts['bizy_use_label_typo']) && !empty($shortcode->atts['bizy_label_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-navbar--item-label'], $shortcode->parse_typography($shortcode->atts['bizy_label_typo']));
    }

    if ( ! empty( $shortcode->atts['bizy_links_color'] ) ) {
        $color = Sanitize::color( $shortcode->atts['color'] );
        $css['global']['%1$s .aheto-navbar--item i']['color'] = $color;
    }

    return $css;
}

add_filter('aheto_navbar_dynamic_css', 'bizy_navbar_layout1_dynamic_css', 10, 2);