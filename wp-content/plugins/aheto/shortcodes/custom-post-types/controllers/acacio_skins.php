<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'acacio_custom_post_types_skins');

/**
 * Custom Post Type
 */

function acacio_custom_post_types_skins($shortcode) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'acacio_skin-1' => esc_html__('Acacio skin 1', 'acacio'),
		'acacio_skin-2' => esc_html__('Acacio skin 2', 'acacio'),
		'acacio_skin-3' => esc_html__('Acacio skin 3', 'acacio'),
		'acacio_skin-4' => esc_html__('Acacio skin 4', 'acacio'),
		'acacio_skin-5' => esc_html__('Acacio skin 5', 'acacio'),
		'acacio_skin-6' => esc_html__('Acacio skin 6', 'acacio'),
        'acacio_skin-7' => esc_html__('Acacio skin 5', 'acacio'),
		'acacio_skin-8' => esc_html__('Acacio skin 6', 'acacio'),
	);

	$all_skins = array_merge($aheto_skins, $aheto_addon_skins);
	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy( 'acacio_use_author_typo', 'skin', ['acacio_skin-1', 'acacio_skin-7'] );
	$shortcode->add_dependecy( 'acacio_author_typo', 'skin', ['acacio_skin-1', 'acacio_skin-7'] );
	$shortcode->add_dependecy( 'acacio_author_typo', 'acacio_use_author_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_date_typo', 'skin', ['acacio_skin-1', 'acacio_skin-7'] );
	$shortcode->add_dependecy( 'acacio_date_typo', 'skin', ['acacio_skin-1', 'acacio_skin-7'] );
	$shortcode->add_dependecy( 'acacio_date_typo', 'acacio_use_date_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_term_typo', 'skin', ['acacio_skin-2'] );
	$shortcode->add_dependecy( 'acacio_term_typo', 'skin', ['acacio_skin-2'] );
	$shortcode->add_dependecy( 'acacio_term_typo', 'acacio_use_term_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_quote_text_typo', 'skin', ['acacio_skin-7', 'acacio_skin-8'] );
	$shortcode->add_dependecy( 'acacio_quote_text_typo', 'skin', ['acacio_skin-7', 'acacio_skin-8'] );
	$shortcode->add_dependecy( 'acacio_quote_text_typo', 'acacio_use_quote_text_typo', 'true' );

	$shortcode->add_dependecy( 'acacio_use_quote_author_typo', 'skin', ['acacio_skin-7', 'acacio_skin-8']);
	$shortcode->add_dependecy( 'acacio_quote_author_typo', 'skin', ['acacio_skin-7', 'acacio_skin-8'] );
	$shortcode->add_dependecy( 'acacio_quote_author_typo', 'acacio_use_quote_author_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_shadow', 'skin', ['acacio_skin-7', 'acacio_skin-8'] );
    $shortcode->add_dependecy( 'acacio_highlight_word', 'skin', ['acacio_skin-7', 'acacio_skin-8'] );
    $shortcode->add_dependecy( 'acacio_highlight_word_typo', 'skin', ['acacio_skin-7', 'acacio_skin-8'] );
    $shortcode->add_dependecy( 'acacio_highlight_word_typo', 'acacio_highlight_word', 'true' );

    $shortcode->add_dependecy( 'acacio_exceprt_typo', 'skin', ['acacio_skin-1', 'acacio_skin-7', 'acacio_skin-8'] );
    $shortcode->add_dependecy( 'acacio_use_excerpt_typo', 'skin', ['acacio_skin-1', 'acacio_skin-7', 'acacio_skin-8'] );
    $shortcode->add_dependecy( 'acacio_exceprt_typo', 'acacio_use_excerpt_typo', 'true' );

    $shortcode->add_params([
        'acacio_highlight_word'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Use custom highlight typography in the last word in title?', 'acacio'),
            'grid'      => 4,
        ],
        'acacio_use_shadow'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Add box shadow?', 'acacio'),
            'grid'      => 5,
        ],

        'acacio_highlight_word_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Highlight Word Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__title a > span',
        ],
        'acacio_use_excerpt_typo'    => [
            'type'      => 'switch',
            'heading'   => esc_html__('Use excerpt typography?', 'acacio'),
            'grid'      => 4,
        ],
        'acacio_exceprt_typo' => [
            'type'     => 'typography',
            'group'    => 'Acacio Excerpt Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
        ],
	    'acacio_use_author_typo'    => [
		    'type'      => 'switch',
		    'heading'   => esc_html__('Use author typography?', 'acacio'),
		    'grid'      => 4,
	    ],
	    'acacio_author_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Author Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-cpt-article__author-meta, {{WRAPPER}} .aheto-cpt-article__author',
	    ],
	    'acacio_use_date_typo'    => [
		    'type'      => 'switch',
		    'heading'   => esc_html__('Use date typography?', 'acacio'),
		    'grid'      => 4,
	    ],
	    'acacio_date_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Date Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
	    ],
	    'acacio_use_term_typo'    => [
		    'type'      => 'switch',
		    'heading'   => esc_html__('Use term typography?', 'acacio'),
		    'grid'      => 4,
	    ],
	    'acacio_term_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Term Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-cpt-article__term',
	    ],
	    'acacio_use_quote_text_typo'    => [
		    'type'      => 'switch',
		    'heading'   => esc_html__('Use quote text typography?', 'acacio'),
		    'grid'      => 4,
	    ],
	    'acacio_quote_text_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Quote Text Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-cpt-article__quote h3',
	    ],
	    'acacio_use_quote_author_typo'    => [
		    'type'      => 'switch',
		    'heading'   => esc_html__('Use quote author typography?', 'acacio'),
		    'grid'      => 4,
	    ],
	    'acacio_quote_author_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Acacio Quote Author Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-cpt-article__quote cite',
	    ],

    ]);
	
}

function acacio_custom_post_types_skins_dynamic_css($css, $shortcode)
{

	if (!empty($shortcode->atts['acacio_use_excerpt_typo']) && !empty($shortcode->atts['acacio_excerpt_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-cpt-article__excerpt p'], $shortcode->parse_typography($shortcode->atts['acacio_excerpt_typo']));
	}

    if (!empty($shortcode->atts['acacio_highlight_word']) && !empty($shortcode->atts['acacio_highlight_word_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt-article__title a > span'], $shortcode->parse_typography($shortcode->atts['acacio_highlight_word_typo']));
    }

	if ( ! empty( $shortcode->atts['acacio_use_author_typo'] ) && ! empty( $shortcode->atts['acacio_date_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography( $shortcode->atts['acacio_author_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['acacio_use_term_typo'] ) && ! empty( $shortcode->atts['acacio_term_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__term'], $shortcode->parse_typography( $shortcode->atts['acacio_term_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['acacio_use_quote_text_typo'] ) && ! empty( $shortcode->atts['acacio_quote_text_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__quote h3'], $shortcode->parse_typography( $shortcode->atts['acacio_quote_text_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['acacio_use_quote_author_typo'] ) && ! empty( $shortcode->atts['acacio_quote_author_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__quote cite'], $shortcode->parse_typography( $shortcode->atts['acacio_quote_author_typo'] ) );
	}

	return $css;
}

add_filter('aheto_cpt_dynamic_css', 'acacio_custom_post_types_skins_dynamic_css', 10, 2);
