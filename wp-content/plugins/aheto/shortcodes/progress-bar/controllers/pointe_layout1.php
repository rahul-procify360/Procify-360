<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'pointe_progress_bar_layout1');
/**
 * Progress Bar Shortcode
 */

function pointe_progress_bar_layout1($shortcode)
{

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('pointe_layout1', [
		'title' => esc_html__('Pointe Inline Progress Bar', 'pointe'),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	]);

	aheto_demos_add_dependency(['percentage', 'heading'], ['pointe_layout1'], $shortcode);
	
	//  Pointe Inline Progress Bar
    $shortcode->add_dependecy('pointe_line_color', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_active_color', 'template', 'pointe_layout1');

    $shortcode->add_dependecy('pointe_use_text_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_text_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_text_typo', 'pointe_use_text_typo', 'true');

	$shortcode->add_params([
		'pointe_use_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for heading?', 'pointe'),
            'grid'    => 3,
        ],
        'pointe_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Heading Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title, {{WRAPPER}} .aheto-progress__bar-perc',
        ],

        'pointe_line_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__('Line color', 'pointe'),
            'grid'      => 6,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__bar' => 'background: {{VALUE}}',
            ],
        ],
        'pointe_active_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__('Active line color', 'pointe'),
            'grid'      => 6,
            'default'   => '#fff',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__bar-val'         => 'background: {{VALUE}}',
                '{{WRAPPER}} .aheto-progress__bar-val::before' => 'background: {{VALUE}}',
            ],
        ]
	]);
}

function pointe_progress_bar_layout1_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['pointe_use_text_typo']) && !empty($shortcode->atts['pointe_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
        \aheto_add_props($css['global']['%1$s .aheto-progress__bar-perc'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
    }
    if (!empty($shortcode->atts['pointe_line_color'])) {
        $color                                                    = Sanitize::color($shortcode->atts['pointe_line_color']);
        $css['global']['%1$s .aheto-progress__bar']['background'] = $color;
    }
    if (!empty($shortcode->atts['pointe_active_color'])) {
        $color                                                                = Sanitize::color($shortcode->atts['pointe_active_color']);
        $css['global']['%1$s .aheto-progress__bar-val']['background']         = $color;
        $css['global']['%1$s .aheto-progress__bar-val::before']['background'] = $color;
    }
    return $css;
}

add_filter('aheto_navigation_dynamic_css', 'pointe_progress_bar_layout1_dynamic_css', 10, 2);
