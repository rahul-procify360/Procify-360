<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'mooseoom_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function mooseoom_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'mooseoom_skin-1' => 'Mooseoom skin 1',
		'mooseoom_skin-2' => 'Mooseoom skin 2',
		'mooseoom_skin-3' => 'Mooseoom skin 3',
		'mooseoom_skin-4' => 'Mooseoom skin 4',
		'mooseoom_skin-5' => 'Mooseoom skin 5',
		'mooseoom_skin-6' => 'Mooseoom skin 6',
		'mooseoom_skin-7' => 'Mooseoom skin 7',
		'mooseoom_skin-8' => 'Mooseoom skin 8',
		'mooseoom_skin-9' => 'Mooseoom skin 9'
	);

	$shortcode->add_dependecy('mooseoom_use_tags_typo', 'skin', 'mooseoom_skin-6' );
	$shortcode->add_dependecy( 'mooseoom_tags_typo', 'skin', 'mooseoom_skin-6' );
	$shortcode->add_dependecy( 'mooseoom_tags_typo', 'mooseoom_use_tags_typo', 'true' );
	$shortcode->add_dependecy('mooseoom_use_filtr_typo', 'skin', ['mooseoom_skin-6', 'mooseoom_skin-2'] );
	$shortcode->add_dependecy( 'mooseoom_filtr_typo', 'skin', ['mooseoom_skin-6', 'mooseoom_skin-2'] );
	$shortcode->add_dependecy( 'mooseoom_filtr_typo', 'mooseoom_use_filtr_typo', 'true' );
	$shortcode->add_dependecy('mooseoom_use_filtractive_typo', 'skin', ['mooseoom_skin-6', 'mooseoom_skin-2'] );
	$shortcode->add_dependecy( 'mooseoom_filtractive_typo', 'skin', ['mooseoom_skin-6', 'mooseoom_skin-2'] );
	$shortcode->add_dependecy( 'mooseoom_filtractive_typo', 'mooseoom_use_filtractive_typo', 'true' );

    $shortcode->add_dependecy('mooseoom_title_hover', 'skin', 'mooseoom_skin-2' );

    $shortcode->add_dependecy('mooseoom_use_excerpt_typo', 'skin', 'mooseoom_skin-2' );
    $shortcode->add_dependecy('mooseoom_excerpt_typo', 'skin', 'mooseoom_skin-2' );
    $shortcode->add_dependecy('mooseoom_excerpt_typo', 'mooseoom_use_excerpt_typo', 'true' );

	$shortcode->add_dependecy('mooseoom_use_date_typo', 'skin', ['mooseoom_skin-1', 'mooseoom_skin-2', 'mooseoom_skin-3', 'mooseoom_skin-4', 'mooseoom_skin-5', 'mooseoom_skin-6', 'mooseoom_skin-7', 'mooseoom_skin-8', 'mooseoom_skin-9'] );
	$shortcode->add_dependecy( 'mooseoom_date_typo', 'skin', ['mooseoom_skin-1', 'mooseoom_skin-2', 'mooseoom_skin-3', 'mooseoom_skin-4', 'mooseoom_skin-5', 'mooseoom_skin-6', 'mooseoom_skin-7', 'mooseoom_skin-8', 'mooseoom_skin-9'] );
	$shortcode->add_dependecy( 'mooseoom_date_typo', 'mooseoom_use_date_typo', 'true' );


	$shortcode->add_params( [
        'mooseoom_title_hover' => [
            'type' => 'colorpicker',
            'heading' => esc_html__('Hover color for post title', 'mooseoom'),
            'grid' => 6,
            'selectors' => ['{{WRAPPER}} .aheto-cpt-article__title a:hover' => 'color: {{VALUE}}'],
        ],
        'mooseoom_use_excerpt_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Excerpt?', 'mooseoom' ),
        ],
        'mooseoom_excerpt_typo' => [
            'type'     => 'typography',
            'group'    => 'Mooseoom Excerpt Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
        ],

		'mooseoom_use_filtractive_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for active filter?', 'mooseoom' ),
		],
		'mooseoom_filtractive_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Filter Active Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-filter a.is-active',
		],
		'mooseoom_use_filtr_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for filter?', 'mooseoom' ),
		],
		'mooseoom_filtr_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Filter Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-filter__item a',
		],

		'mooseoom_use_date_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for date?', 'mooseoom' ),
		],
		'mooseoom_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],

		'mooseoom_use_tags_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for tag?', 'mooseoom' ),
		],
		'mooseoom_tags_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Tag Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__tags a',
		],

	] );
	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );
	$shortcode->params['skin']['options'] = $all_skins;
}

function mooseoom_custom_post_types_skins_dynamic_css( $css, $shortcode ) {

    if (isset($shortcode->atts['mooseoom_title_hover']) && !empty($shortcode->atts['mooseoom_title_hover'])) {
        $color = Sanitize::color($shortcode->atts['mooseoom_title_hover']);
        $css['global']['%1$s .aheto-cpt-article__title a:hover']['color'] = $color;
    }

    if ( isset($shortcode->atts['mooseoom_use_excerpt_typo']) && $this->atts['mooseoom_use_excerpt_typo'] && isset($shortcode->atts['mooseoom_excerpt_typo']) && !empty($shortcode->atts['mooseoom_excerpt_typo']) ) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt p'], $shortcode->parse_typography($shortcode->atts['mooseoom_excerpt_typo']));
    }
	if ( !empty($shortcode->atts['mooseoom_use_filtractive_typo']) && !empty($shortcode->atts['mooseoom_filtractive_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-filter a.is-active'], $shortcode->parse_typography($shortcode->atts['mooseoom_filtractive_typo']));
	}
	if ( !empty($shortcode->atts['mooseoom_use_filtr_typo']) && !empty($shortcode->atts['mooseoom_filtr_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-filter__item a'], $shortcode->parse_typography($shortcode->atts['mooseoom_filtr_typo']));
	}
	
	if ( !empty($shortcode->atts['mooseoom_use_date_typo']) && !empty($shortcode->atts['mooseoom_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography($shortcode->atts['mooseoom_date_typo']));
	}
	if ( !empty($shortcode->atts['mooseoom_use_tags_typo']) && !empty($shortcode->atts['mooseoom_tags_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__tags a'], $shortcode->parse_typography($shortcode->atts['mooseoom_tags_typo']));
	}
	return $css;
}

add_filter('aheto_cpt_dynamic_css', 'mooseoom_custom_post_types_skins_dynamic_css_dynamic_css', 10, 2);