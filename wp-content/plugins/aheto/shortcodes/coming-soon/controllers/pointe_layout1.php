<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_coming-soon_register', 'pointe_coming_soon_layout1' );


/**
 * Coming Soon Shortcode
 */

function pointe_coming_soon_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/coming-soon/previews/';

	$shortcode->add_layout( 'pointe_layout1', [
		'title' => esc_html__( 'Pointe Simple', 'pointe' ),
		'image' => $preview_dir . 'pointe_layout1.jpg',
	] );

	aheto_demos_add_dependency(['days_desktop', 'days_mobile', 'hours_desktop', 'hours_mobile', 'mins_desktop', 'mins_mobile', 'secs_desktop', 'secs_mobile', 'use_typo_numbers', 'typo_numbers', 'typo_caption', 'use_typo_caption'], ['pointe_layout1'], $shortcode);
    
    $shortcode->add_dependecy('pointe_use_dot_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_typo_dot', 'template', ['pointe_layout1']);
	$shortcode->add_dependecy('pointe_typo_dot', 'pointe_use_dot_typo', 'true');
	
	$shortcode->add_params([
              
        'pointe_use_dot_typo'    => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Dots?', 'pointe'),
            'grid'    => 6,
        ],

        'pointe_typo_dot'   => [
            'type'     => 'typography',
            'group'    => 'Pointe Dot Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
        ],
    ]);

}
function pointe_coming_soon_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['pointe_use_dot_typo']) && !empty($shortcode->atts['pointe_typo_caption'])) {
        \aheto_add_props($css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography($shortcode->atts['pointe_typo_caption']));
    }

    return $css;
}

add_filter('aheto_coming_soon_dynamic_css', 'pointe_coming_soon_layout1_dynamic_css', 10, 2);