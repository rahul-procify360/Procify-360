<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_twitter_register', 'pointe_twitter_layout1' );

/**
 * Testimonials
 */

function pointe_twitter_layout1( $shortcode ) {

	$theme_dir = '//assets.aheto.co/twitter/previews/';

	$shortcode->add_layout('pointe_layout1', [
        'title' => esc_html__('Pointe twitter', 'pointe'),
        'image' => $theme_dir . 'pointe_layout1.jpg',
    ]);

	aheto_demos_add_dependency(['twitter_user', 'number', 'use_typo_descr', 'typo_descr'], ['pointe_layout1'], $shortcode);
	
	$shortcode->add_dependecy('pointe_use_twitter_typo', 'template', ['pointe_layout1']);
	$shortcode->add_dependecy('pointe_twitter_typo', 'template', ['pointe_layout1']);
    $shortcode->add_dependecy('pointe_twitter_typo', 'pointe_use_twitter_typo', 'true');

	$shortcode->add_params( [
		'pointe_use_twitter_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Twitter User?', 'pointe'),
            'grid'    => 2,
        ],

        'pointe_twitter_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Twitter User Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-twitter--slug',
        ]
	] );
}

function pointe_twitter_layout1_dynamic_css($css, $shortcode)
{
    if (!empty($shortcode->atts['pointe_use_twitter_typo']) && !empty($shortcode->atts['pointe_twitter_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-twitter--slug'], $shortcode->parse_typography($shortcode->atts['pointe_twitter_typo']));
    }

    return $css;
}
add_filter('aheto_twitter_dynamic_css', 'pointe_twitter_layout1_dynamic_css', 10, 2);
