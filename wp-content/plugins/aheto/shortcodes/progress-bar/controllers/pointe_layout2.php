<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'pointe_progress_bar_layout2');
/**
 * Progress Bar Shortcode
 */

function pointe_progress_bar_layout2($shortcode)
{

	$preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('pointe_layout2', [
		'title' => esc_html__('Pointe Inline Progress Bar', 'pointe'),
		'image' => $preview_dir . 'pointe_layout2.jpg',
	]);

	aheto_demos_add_dependency('heading', ['pointe_layout2'], $shortcode);
	
	//  Pointe Inline Progress Bar
    $shortcode->add_dependecy('pointe_number', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_number_tag', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_symbol', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_text_tag', 'template', 'pointe_layout2');

    $shortcode->add_dependecy('pointe_use_text_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_text_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_text_typo', 'pointe_use_text_typo', 'true');

    $shortcode->add_dependecy('pointe_use_number_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_number_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_number_typo', 'pointe_use_number_typo', 'true');

	$shortcode->add_params([
        'pointe_number'    => [
            'type'    => 'text',
            'heading' => esc_html__('Number', 'pointe'),
            'grid'    => 1,
        ],
        'pointe_symbol'    => [
            'type'    => 'text',
            'heading' => esc_html__('Symbol', 'pointe'),
            'grid'    => 2,
        ],
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
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title, {{WRAPPER}} .aheto-progress__bar-perc',
        ],
        'pointe_use_number_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for number?', 'pointe'),
        ],

        'pointe_number_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Number Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number, {{WRAPPER}} .aheto-counter__number-wrap span',
        ],
        'pointe_number_tag' => [
            'type'    => 'select',
            'heading' => esc_html__('Element tag for number', 'pointe'),
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
        'pointe_text_tag' => [
            'type'    => 'select',
            'heading' => esc_html__('Element tag for text', 'pointe'),
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
	]);
}

function pointe_progress_bar_layout2_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['pointe_use_text_typo']) && !empty($shortcode->atts['pointe_text_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-progress__title'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
        \aheto_add_props($css['global']['%1$s .aheto-progress__bar-perc'], $shortcode->parse_typography($shortcode->atts['pointe_text_typo']));
    }
    
    if (!empty($shortcode->atts['pointe_use_number_typo']) && !empty($shortcode->atts['pointe_number_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography($shortcode->atts['pointe_number_typo']));
        \aheto_add_props($css['global']['%1$s .aheto-counter__number-wrap span'], $shortcode->parse_typography($shortcode->atts['pointe_number_typo']));
    }
   
   
    return $css;
}

add_filter('aheto_navigation_dynamic_css', 'pointe_progress_bar_layout2_dynamic_css', 10, 2);
