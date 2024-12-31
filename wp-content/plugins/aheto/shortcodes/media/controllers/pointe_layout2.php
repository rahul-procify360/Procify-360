<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'pointe_media_layout2');


/**
 * Media Shortcode
 */

function pointe_media_layout2($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';
	$shortcode->add_layout('pointe_layout2', [
		'title' => esc_html__('Pointe Media video', 'pointe'),
		'image' => $preview_dir . 'pointe_layout2.jpg',
    ]);
    
    $shortcode->add_dependecy('pointe_align', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_flitr_all', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_medias', 'template', 'pointe_layout2');

	$shortcode->add_dependecy('pointe_use_filtr_typo', 'template', 'pointe_layout2');
	$shortcode->add_dependecy('pointe_filtr_typo', 'template', 'pointe_layout2');
    $shortcode->add_dependecy('pointe_filtr_typo', 'pointe_use_filtr_typo', 'true');

	$shortcode->add_params([
        'pointe_align'         => [
            'type'    => 'select',
            'heading' => esc_html__('Align Load Button', 'pointe'),
            'grid'    => 6,
            'options' => \Aheto\Helper::choices_alignment()
        ],
        'pointe_flitr_all'          => [
            'type'    => 'text',
            'heading' => esc_html__('All filter name', 'pointe'),
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
        'pointe_medias'               => [
            'type'    => 'group',
            'heading' => esc_html__('Pointe Consult Pricing Items', 'pointe'),
            'params'  => [
                'pointe_medias_heading' => [
                    'type'    => 'text',
                    'heading' => esc_html__('Category', 'pointe'),
                    'default' => esc_html__('Put your text...', 'pointe'),
                ],
                'pointe_image2'        => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__('Video Image', 'pointe'),
                ],
            ],
        ]
	]);
	\Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'pointe_',
        'dependency' => ['template', ['pointe_layout2']]
    ]);
    \Aheto\Params::add_video_button_params($shortcode, [
        'add_label' => esc_html__('Add video button?', 'pointe'),
        'prefix'    => 'pointe_',
        'group'     => esc_html__('Video Content', 'pointe'),
    ], 'pointe_medias');
}

function pointe_media_layout2_dynamic_css($css, $shortcode)
{
    
    if (!empty($shortcode->atts['pointe_use_filtr_typo']) && !empty($shortcode->atts['pointe_filtr_typo'])) {
        \aheto_add_props($css['global']['%1$s .boxed-grid-filters .button'], $shortcode->parse_typography($shortcode->atts['pointe_filtr_typo']));
    }

    return $css;
}

add_filter('aheto_pointe_media_dynamic_css', 'pointe_media_layout2_dynamic_css', 10, 2);