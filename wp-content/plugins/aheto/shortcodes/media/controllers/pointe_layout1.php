<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'pointe_media_layout1');


/**
 * Media Shortcode
 */

function pointe_media_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';
	$shortcode->add_layout('pointe_layout1', [
		'title' => esc_html__('Pointe Media filtr', 'pointe'),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	]);

	$shortcode->add_dependecy('pointe_use_filtr_typo', 'template', 'pointe_layout1');
	$shortcode->add_dependecy('pointe_filtr_typo', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_filtr_typo', 'pointe_use_filtr_typo', 'true');

    $shortcode->add_dependecy('pointe_image', 'template', 'pointe_layout1');
    $shortcode->add_dependecy('pointe_flitr_all', 'template', 'pointe_layout1');

	$shortcode->add_params([
	
        'pointe_flitr_all'          => [
            'type'    => 'text',
            'heading' => esc_html__('All filter name', 'pointe'),
        ],
        'pointe_image'     => [
            'type'    => 'attach_images',
            'heading' => esc_html__('Add image', 'pointe'),
		],
		'pointe_use_filtr_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Filtr?', 'pointe'),
            'grid'    => 3,
        ],

        'pointe_filtr_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Filtr Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .boxed-grid-filters .button, {{WRAPPER}} .aheto-media__head a'
        ],
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'pointe_',
        'dependency' => ['template', ['pointe_layout1']]
    ]);
}

function pointe_media_layout1_dynamic_css($css, $shortcode)
{
    
    if (!empty($shortcode->atts['pointe_use_filtr_typo']) && !empty($shortcode->atts['pointe_filtr_typo'])) {
        \aheto_add_props($css['global']['%1$s .boxed-grid-filters .button'], $shortcode->parse_typography($shortcode->atts['pointe_filtr_typo']));
    }

    return $css;
}

add_filter('aheto_pointe_media_dynamic_css', 'pointe_media_layout1_dynamic_css', 10, 2);