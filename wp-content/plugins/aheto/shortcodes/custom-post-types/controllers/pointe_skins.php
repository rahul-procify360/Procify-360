<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'pointe_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function pointe_custom_post_types_skins( $shortcode ) {

	$aheto_skins    = $shortcode->params['skin']['options'];
    $pointe_skins = array(
        'pointe_skin-1' => 'Pointe skin 1',
        'pointe_skin-2' => 'Pointe skin 2',
        'pointe_skin-3' => 'Pointe skin 3',
    );

	$all_skins = array_merge($aheto_skins, $pointe_skins);
    $shortcode->params['skin']['options'] = $all_skins;

	aheto_demos_add_dependency(['use_heading', 't_heading'], ['pointe_skin-1'], $shortcode);

    $shortcode->add_dependecy('pointe_link_text', 'skin', 'pointe_skin-3');
    
    $shortcode->add_dependecy('pointe_use_date_typo', 'skin', 'pointe_skin-1');
    $shortcode->add_dependecy('pointe_date_typo', 'skin', 'pointe_skin-1');
    $shortcode->add_dependecy('pointe_date_typo', 'pointe_use_date_typo', 'true');

    $shortcode->add_dependecy('pointe_use_date_month_typo', 'skin', 'pointe_skin-1');
    $shortcode->add_dependecy('pointe_date_month_typo', 'skin', 'pointe_skin-1');
    $shortcode->add_dependecy('pointe_date_month_typo', 'pointe_use_date_month_typo', 'true');

	$shortcode->add_params( [

		'pointe_use_date_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Date?', 'pointe'),
        ],
        'pointe_date_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Date Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
        ],

        'pointe_use_date_month_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for Date month?', 'pointe'),
        ],
        'pointe_date_month_typo' => [
            'type'     => 'typography',
            'group'    => 'Pointe Month Typography',
            'settings' => [
                'tag'        => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__date b',
        ],
        'pointe_link_text' => [
            'type' => 'text',
            'heading' => esc_html__('Use Button', 'pointe')
        ]

	] );

}

function pointe_custom_post_types_skins_dynamic_css( $css, $shortcode ) {

	if (!empty($shortcode->atts['pointe_use_date_month_typo']) && !empty($shortcode->atts['pointe_date_month_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__date b'], $shortcode->parse_typography($shortcode->atts['pointe_date_month_typo']));
    }
    if (!empty($shortcode->atts['pointe_use_date_typo']) && !empty($shortcode->atts['pointe_date_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['pointe_date_typo']));
	}
	
	return $css;
}

add_filter('aheto_cpt_dynamic_css', 'pointe_custom_post_types_skins_dynamic_css_dynamic_css', 10, 2);