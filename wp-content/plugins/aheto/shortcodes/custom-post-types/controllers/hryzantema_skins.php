<?php

use Aheto\Helper;

add_action('aheto_before_aheto_custom-post-types_register', 'hryzantema_custom_post_types_skins');

/**
 * Custom post type Shortcode
 */

function hryzantema_custom_post_types_skins($shortcode) {
	$aheto_skins = $shortcode->params['skin']['options'];
	$hr_skins = array(
		'hryzantema_skin-1' => 'HR Consult Skin 1',
		'hryzantema_skin-2' => 'HR Consult Skin 2',
		'hryzantema_skin-3' => 'HR Consult Skin 3',
		'hryzantema_skin-4' => 'HR Consult Skin 4',
		'hryzantema_skin-5' => 'HR Consult Skin 5',
		'hryzantema_skin-6' => 'HR Consult Skin 6',
		'hryzantema_skin-7' => 'HR Consult Skin 7',
		'hryzantema_skin-8' => 'HR Consult Skin 8',
	);

	$all_skins = array_merge($aheto_skins, $hr_skins);

	$shortcode->params['skin']['options'] = $all_skins;

	$shortcode->add_dependecy( 'hryzantema_hide_thumbnail', 'skin', 'hryzantema_skin-4' );
	$shortcode->add_dependecy( 'hryzantema_hide_thumbnail', 'skin', 'hryzantema_skin-1' );
	$shortcode->add_dependecy( 'hryzantema_use_excerpt_typo', 'skin', 'hryzantema_skin-1' );
	$shortcode->add_dependecy( 'hryzantema_excerpt_typo', 'skin', 'hryzantema_skin-1' );
	$shortcode->add_dependecy( 'hryzantema_excerpt_typo', 'hryzantema_use_excerpt_typo', 'true' );
	$shortcode->add_dependecy( 'hryzantema_use_excerpt_typo', 'skin', 'hryzantema_skin-6' );
	$shortcode->add_dependecy( 'hryzantema_excerpt_typo', 'skin', 'hryzantema_skin-6' );

	$shortcode->add_dependecy( 'hryzantema_use_excerpt_typo', 'skin', 'hryzantema_skin-7' );
	$shortcode->add_dependecy( 'hryzantema_excerpt_typo', 'skin', 'hryzantema_skin-7' );

	$shortcode->add_dependecy( 'hryzantema_use_author_typo', 'skin', ['hryzantema_skin-1', 'hryzantema_skin-4', 'hryzantema_skin-7'] );
	$shortcode->add_dependecy( 'hryzantema_author_typo', 'skin', ['hryzantema_skin-1', 'hryzantema_skin-4', 'hryzantema_skin-7'] );
	$shortcode->add_dependecy( 'hryzantema_author_typo', 'hryzantema_use_author_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_date_typo', 'skin', ['hryzantema_skin-1', 'hryzantema_skin-5', 'hryzantema_skin-7', 'hryzantema_skin-8'] );
	$shortcode->add_dependecy( 'hryzantema_date_typo', 'skin', ['hryzantema_skin-1', 'hryzantema_skin-5', 'hryzantema_skin-7', 'hryzantema_skin-8'] );
	$shortcode->add_dependecy( 'hryzantema_date_typo', 'hryzantema_use_date_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_excerpt_typo', 'skin', 'hryzantema_skin-8' );
	$shortcode->add_dependecy( 'hryzantema_excerpt_typo', 'skin', 'hryzantema_skin-8' );

	$shortcode->add_dependecy( 'hryzantema_use_btn_typo', 'skin', 'hryzantema_skin-6' );
	$shortcode->add_dependecy( 'hryzantema_btn_typo', 'skin', 'hryzantema_skin-6' );
	$shortcode->add_dependecy( 'hryzantema_btn_typo', 'hryzantema_use_btn_typo', 'true' );

	$shortcode->add_dependecy( 'hryzantema_use_title_big_typo', 'skin', 'hryzantema_skin-2' );
	$shortcode->add_dependecy( 'hryzantema_title_big_typo', 'skin', 'hryzantema_skin-2' );
	$shortcode->add_dependecy( 'hryzantema_title_big_typo', 'hryzantema_use_title_big_typo', 'true' );
	$shortcode->add_params( [
		'hryzantema_hide_thumbnail' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Hide thumbnail?', 'hryzantema' ),
			'grid'    => 6,
		],
		'hryzantema_use_excerpt_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for excerpt?', 'hryzantema' ),
			'grid'    => 2,
		],

		'hryzantema_excerpt_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Excerpt Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
		],

		'hryzantema_use_author_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for author?', 'hryzantema' ),
			'grid'    => 2,
		],

		'hryzantema_author_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Author Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__author-meta, {{WRAPPER}} .aheto-cpt-article__author',
		],
		'hryzantema_use_date_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for date?', 'hryzantema' ),
			'grid'    => 2,
		],

		'hryzantema_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],
		'hryzantema_use_btn_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for button?', 'hryzantema' ),
			'grid'    => 2,
		],

		'hryzantema_btn_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Button Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__button a',
		],
		'hryzantema_use_title_big_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for big title?', 'hryzantema' ),
			'grid'    => 2,
		],
		'hryzantema_title_big_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Big Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article--hryzantema_skin-2:nth-child(7n+2) .aheto-cpt-article__title',
		],
	]);
	\Aheto\Params::add_button_params( $shortcode, [
		'prefix' => 'hryzantema_main_',
		'icons' => true,
		'dependency'     => [ 'skin', [ 'hryzantema_skin-4', 'hryzantema_skin-6' ] ],
		'group'      => esc_html__( 'Hryzantema Button', 'hryzantema' ),
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon' => true,
		'add_label'  => esc_html__( 'Add icon?', 'hryzantema' ),
		'prefix'     => 'hryzantema_',
		'exclude'  => ['align'],
		'dependency' => ['skin', ['hryzantema_skin-8']],
		'group'      => esc_html__( 'Hryzantema Icon', 'hryzantema' ),
	]);
}
function hryzantema_cpt_skin_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_author_typo'] ) && $shortcode->atts['hryzantema_use_author_typo'] && isset( $shortcode->atts['hryzantema_author_typo'] ) && ! empty( $shortcode->atts['hryzantema_author_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__author-meta, %1$s .aheto-cpt-article__author'], $shortcode->parse_typography( $shortcode->atts['hryzantema_author_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_date_typo'] ) && $shortcode->atts['hryzantema_use_date_typo'] && isset( $shortcode->atts['hryzantema_date_typo'] ) && ! empty( $shortcode->atts['hryzantema_date_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__date'], $shortcode->parse_typography( $shortcode->atts['hryzantema_date_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_btn_typo'] ) && $shortcode->atts['hryzantema_use_btn_typo'] && isset( $shortcode->atts['hryzantema_btn_typo'] ) && ! empty( $shortcode->atts['hryzantema_btn_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__button a'], $shortcode->parse_typography( $shortcode->atts['hryzantema_btn_typo'] ) );
	}
	if ( isset( $shortcode->atts['hryzantema_use_title_big_typo'] ) && $shortcode->atts['hryzantema_use_title_big_typo'] && isset( $shortcode->atts['hryzantema_title_big_typo'] ) && ! empty( $shortcode->atts['hryzantema_title_big_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article--hryzantema_skin-2:nth-child(7n+2) .aheto-cpt-article__title'], $shortcode->parse_typography( $shortcode->atts['hryzantema_title_big_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'hryzantema_cpt_skin_dynamic_css', 10, 2 );

