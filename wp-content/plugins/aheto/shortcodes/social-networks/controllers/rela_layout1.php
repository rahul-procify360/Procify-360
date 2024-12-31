<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'rela_social_networks_layout1');

/**
 * Social Networks
 */
function rela_social_networks_layout1($shortcode)
{

    $shortcode_dir = '//assets.aheto.co/social-networks/previews/';

    $shortcode->add_layout('rela_layout1', [
        'title' => esc_html__('Social Networks 10', 'rela'),
        'image' => $shortcode_dir . 'rela_layout1.jpg',
    ]);

    $shortcode->add_dependecy('rela_hovercolor', 'template', 'rela_layout1');

    $shortcode->add_dependecy( 'rela_use_text_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_text_typo', 'template', 'rela_layout1' );
    $shortcode->add_dependecy( 'rela_text_typo', 'rela_use_text_typo', 'true' );

    aheto_demos_add_dependency(['networks', 'socials_align_mob', 'socials_align', 'size'], ['rela_layout1'], $shortcode);

    $shortcode->add_params([
        'rela_use_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for social name?', 'rela' ),
            'grid'    => 3,
        ],
        'rela_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Rela Social Name Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-socials__link',
        ],
        'rela_hovercolor' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Color on hover', 'rela'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-socials__link:hover' => 'color: {{VALUE}}'],
        ],
    ]);
}

function rela_social_networks_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['rela_hovercolor'])) {
        $color = Sanitize::color($shortcode->atts['rela_hovercolor']);
        $css['global']['%1$s .aheto-socials__link:hover']['color'] = $color;
    }
    if ( ! empty( $shortcode->atts['rela_use_text_typo'] ) && ! empty( $shortcode->atts['rela_text_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-socials__link'], $shortcode->parse_typography( $shortcode->atts['rela_text_typo'] ) );
    }
    return $css;
}

add_filter('aheto_social_networks_dynamic_css', 'rela_social_networks_layout1_dynamic_css', 10, 2);
