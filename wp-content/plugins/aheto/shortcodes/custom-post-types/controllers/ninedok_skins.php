<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'ninedok_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function ninedok_custom_post_types_skins( $shortcode ) {

    $aheto_skins  = $shortcode->params['skin']['options'];
    $aheto_addon_skins = array(
        'ninedok_skin-1' => 'Ninedok skin 1',
        'ninedok_skin-2' => 'Ninedok skin 2',
        'ninedok_skin-3' => 'Ninedok skin 3',
        'ninedok_skin-4' => 'Ninedok skin 4',
        'ninedok_skin-5' => 'Ninedok skin 5',
    );

    $all_skins = array_merge( $aheto_skins, $aheto_addon_skins );


    $shortcode->params['skin']['options'] = $all_skins;
    
    $shortcode->add_dependecy('ninedok_img_off', 'skin', 'ninedok_skin-1');
    $shortcode->add_dependecy('ninedok_date_off', 'skin', 'ninedok_skin-1');

    $shortcode->add_dependecy( 'ninedok_use_excerpt_typo', 'skin', ['ninedok_skin-3' , 'ninedok_skin-4']);
    $shortcode->add_dependecy( 'ninedok_excerpt_typo', 'skin', ['ninedok_skin-3' , 'ninedok_skin-4' ]);
    $shortcode->add_dependecy( 'ninedok_excerpt_typo', 'ninedok_use_excerpt_typo', 'true' );

	$shortcode->add_dependecy('ninedok_use_date_typo', 'skin', 'ninedok_skin-2');
    $shortcode->add_dependecy( 'ninedok_date_typo', 'skin', 'ninedok_skin-2');
    $shortcode->add_dependecy( 'ninedok_date_typo', 'ninedok_use_date_typo', 'true' );

	$shortcode->add_dependecy('ninedok_use_author_typo', 'skin', 'ninedok_skin-1');
	$shortcode->add_dependecy( 'ninedok_author_typo', 'skin', 'ninedok_skin-1' );
	$shortcode->add_dependecy( 'ninedok_author_typo', 'ninedok_use_author_typo', 'true' );

	$shortcode->add_dependecy('ninedok_use_terms_typo', 'skin', 'ninedok_skin-4');
	$shortcode->add_dependecy( 'ninedok_terms_typo', 'skin', 'ninedok_skin-4' );
	$shortcode->add_dependecy( 'ninedok_terms_typo', 'ninedok_use_terms_typo', 'true' );

	$shortcode->add_dependecy('ninedok_use_quote_typo', 'skin', 'ninedok_skin-4');
	$shortcode->add_dependecy( 'ninedok_quote_typo', 'skin', 'ninedok_skin-4' );
	$shortcode->add_dependecy( 'ninedok_quote_typo', 'ninedok_use_quote_typo', 'true' );

    $shortcode->add_params( [
        'ninedok_img_off' => [
            'type'    => 'switch',
            'heading' => esc_html__('Disable post image?', 'ninedok'),
            'grid'    => 12,
        ],
        'ninedok_date_off' => [
            'type'    => 'switch',
            'heading' => esc_html__('Disable post date?', 'ninedok'),
            'grid'    => 12,
        ],
        'ninedok_use_date_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for date?', 'ninedok' ),
            'grid'    => 3,
        ],
        'ninedok_date_typo' => [
            'type'     => 'typography',
            'group'    => 'Ninedok Date Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
        ],
        'ninedok_use_excerpt_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for excerpt?', 'ninedok' ),
            'grid'    => 2,
        ],

        'ninedok_excerpt_typo' => [
            'type'     => 'typography',
            'group'    => 'Ninedok Excerpt Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
        ],
	    'ninedok_use_author_typo' => [
		    'type'    => 'switch',
		    'heading' => esc_html__( 'Use custom font for author?', 'ninedok' ),
		    'grid'    => 2,
	    ],
	    'ninedok_author_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Ninedok Author Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-cpt-article__author',
	    ],
	    'ninedok_use_terms_typo' => [
		    'type'    => 'switch',
		    'heading' => esc_html__( 'Use custom font for terms?', 'ninedok' ),
		    'grid'    => 2,
	    ],
	    'ninedok_terms_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Ninedok Terms Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-cpt-article__terms a',
	    ],
	    'ninedok_use_quote_typo' => [
		    'type'    => 'switch',
		    'heading' => esc_html__( 'Use custom font for quote?', 'ninedok' ),
		    'grid'    => 2,
	    ],
	    'ninedok_quote_typo' => [
		    'type'     => 'typography',
		    'group'    => 'Ninedok Quote Typography',
		    'settings' => [
			    'tag'        => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-quote h4',
	    ],

    ] );
    \Aheto\Params::add_icon_params($shortcode, [
        'add_icon' => true,
        'group' => 'Content',
        'add_label'  => esc_html__( 'Add icon for Button?', 'ninedok' ),
        'prefix'     => 'ninedok_',
        'exclude'  => ['align'],
        'dependency'     => [ 'skin', [ 'ninedok_skin-3' ] ]
    ]);
}
function ninedok_cpt_skins_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['ninedok_use_date_typo'] ) && ! empty( $shortcode->atts['ninedok_date_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography( $shortcode->atts['ninedok_use_date_typo'] ) );
    }

	if ( ! empty( $shortcode->atts['ninedok_use_author_typo'] ) && ! empty( $shortcode->atts['ninedok_author_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__author'], $shortcode->parse_typography( $shortcode->atts['ninedok_author_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['ninedok_use_terms_typo'] ) && ! empty( $shortcode->atts['ninedok_terms_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__terms a'], $shortcode->parse_typography( $shortcode->atts['ninedok_terms_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['ninedok_use_quote_typo'] ) && ! empty( $shortcode->atts['ninedok_quote_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-quote h4'], $shortcode->parse_typography( $shortcode->atts['ninedok_quote_typo'] ) );
	}
    return $css;
}add_filter( 'aheto_cpt_dynamic_css', 'ninedok_cpt_skins_dynamic_css', 10, 2 );