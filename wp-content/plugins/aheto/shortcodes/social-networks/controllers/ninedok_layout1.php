<?php

use Aheto\Helper;

add_action('aheto_before_aheto_social-networks_register', 'ninedok_social_networks_layout1');

/**
 * Social Networks
 */

function ninedok_social_networks_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/social-networks/previews/';

    $shortcode->add_layout('ninedok_layout1', [
        'title' => esc_html__('Social Networks 8', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout1.jpg',
    ]);

    aheto_demos_add_dependency(['networks', 'socials_align_mob', 'socials_align'], ['ninedok_layout1'], $shortcode);

    $shortcode->add_dependecy('ninedok_color', 'template', 'ninedok_layout1');
	$shortcode->add_dependecy('socials_align_tablet', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_hovercolor', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_use_link_typo', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_link_typo', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_link_typo', 'ninedok_use_link_typo', 'true');

    $shortcode->add_params([
        'socials_align_tablet' => [
            'type' => 'select',
            'heading' => esc_html__('Socials align on tablet', 'ninedok'),
            'grid' => 6,
            'options' => [
                'left' => esc_html__('Left', 'ninedok'),
                'right' => esc_html__('Right', 'ninedok'),
                'center' => esc_html__('Center', 'ninedok'),
                'justify' => esc_html__('Justify', 'ninedok'),
            ],
        ],
        'ninedok_hovercolor' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Color on hover', 'ninedok'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-socials__link:hover' => 'color: {{VALUE}}'],
        ],
        'ninedok_use_link_typo' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for link?', 'ninedok'),
            'grid' => 3,
        ],
        'ninedok_link_typo' => [
            'type' => 'typography',
            'group' => 'Ninedok Link Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-socials__link',
        ],
    ]);
}

function ninedok_social_networks_layout1_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['ninedok_use_link_typo']) && !empty($shortcode->atts['ninedok_link_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-tm__bg-text'], $shortcode->parse_typography($shortcode->atts['ninedok_link_typo']));
    }

    if (!empty($shortcode->atts['ninedok_color'])) {
        $color = Sanitize::color($shortcode->atts['ninedok_color']);
        $css['global']['%1$s .aheto-socials__link']['color'] = $color;
    }
    if (!empty($shortcode->atts['ninedok_hovercolor'])) {
        $color = Sanitize::color($shortcode->atts['ninedok_hovercolor']);
        $css['global']['%1$s .aheto-socials__link:hover']['color'] = $color;
    }
    return $css;
}

add_filter('aheto_social_networks_dynamic_css', 'ninedok_social_networks_layout1_dynamic_css', 10, 2);
