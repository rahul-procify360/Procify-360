<?php

add_action( 'aheto_before_aheto_custom-post-types_register', 'snapster_custom_post_types_skins_shortcode' );

/**
 * Custom post type style for blog items
 */

function snapster_custom_post_types_skins_shortcode($shortcode) {

	$aheto_skins      = $shortcode->params["skin"]["options"];
	$snapster_skins = array(
		"snapster_skin-1" => "Snapster skin 1",
		"snapster_skin-2" => "Snapster skin 2",
		"snapster_skin-3" => "Snapster skin 3",
		"snapster_skin-4" => "Snapster skin 4",
		"snapster_skin-5" => "Snapster skin 5",
		"snapster_skin-6" => "Snapster skin 6",
		"snapster_skin-7" => "Snapster skin 7",
		"snapster_skin-8" => "Snapster skin 8",
		"snapster_skin-9" => "Snapster skin 9"
	);

	$all_skins = array_merge($aheto_skins, $snapster_skins);
	$shortcode->params['skin']['options'] = $all_skins;

	$aheto_mosaics_skins      = $shortcode->params["mosaics_skin"]["options"];

	$all_mosaics_skins = array_merge($aheto_mosaics_skins, $snapster_skins);
	$shortcode->params['mosaics_skin']['options'] = $all_mosaics_skins;

	$shortcode->add_dependecy("snapster_slides_title", "skin", "snapster_skin-4" );
	$shortcode->add_dependecy("snapster_grayscale", "skin", "snapster_skin-4" );

	$shortcode->add_dependecy("snapster_use_date_typo", "skin", "snapster_skin-1" );
	$shortcode->add_dependecy("snapster_date_typo", "skin", "snapster_skin-1" );
	$shortcode->add_dependecy("snapster_date_typo", "snapster_use_date_typo", "true" );

	$shortcode->add_dependecy("snapster_use_excerpt_typo", "skin", ["snapster_skin-5", "snapster_skin-9"]);
	$shortcode->add_dependecy("snapster_excerpt_typo", "skin", ["snapster_skin-5", "snapster_skin-9"]);
	$shortcode->add_dependecy("snapster_excerpt_typo", "snapster_use_excerpt_typo", "true" );

	$shortcode->add_dependecy("snapster_use_link_typo", "skin", "snapster_skin-9");
	$shortcode->add_dependecy("snapster_link_typo", "skin",  "snapster_skin-9");
	$shortcode->add_dependecy("snapster_link_typo", "snapster_use_link_typo", "true" );

	$shortcode->add_dependecy("snapster_overlay_skin", "skin", "snapster_skin-7" );
	$shortcode->add_dependecy("snapster_paddings", "skin", ["snapster_skin-1", "snapster_skin-7", "snapster_skin-9"] );
	$shortcode->add_dependecy("snapster_btn_style", "skin", "snapster_skin-9" );
	$shortcode->add_dependecy("snapster_title_paddings", "skin", "snapster_skin-9" );
	$shortcode->add_dependecy("snapster_term_paddings", "skin", "snapster_skin-9" );
	$shortcode->add_dependecy("snapster_excerpt_paddings", "skin", ["snapster_skin-1"] );
	$shortcode->add_dependecy("snapster_link_paddings", "skin", ["snapster_skin-1"] );
	$shortcode->add_dependecy("snapster_overlay_link", "skin", ["snapster_skin-4"] );


	$shortcode->add_params([
		'snapster_btn_style' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Button style', 'aheto' ),
			'options' => [
				'aheto-btn--main' => esc_html__( 'Default', 'aheto' ),
				'aheto-btn--primary' => esc_html__( 'Primary', 'aheto' ),
				'aheto-btn--dark'    => esc_html__( 'Dark', 'aheto' ),
				'aheto-btn--white'   => esc_html__( 'White', 'aheto' ),
			],
			'default' => 'aheto-btn--main',
		],
		'snapster_grayscale' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable grayscale for images?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_use_date_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Date?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Snapster Date Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__date',
		],
		'snapster_slides_title' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Title for slides', 'snapster' ),
			'default'    => 'Book',
		],
		'snapster_use_excerpt_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for excerpt?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_excerpt_typo' => [
			'type'     => 'typography',
			'group'    => 'Snapster Excerpt Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt',
		],
		'snapster_paddings'    => [
			'type'      => 'responsive_spacing',
			'heading'   => esc_html__( 'Block padding', 'snapster' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-cpt-article__content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'snapster_overlay_link' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable light overlay?', 'snapster' ),
			'grid'    => 3,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__img-link:hover' => 'background: rgba(var(--ca-light),.5)' ],
		],
		'snapster_overlay_skin' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Block overlay', 'snapster' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .bg-overlay' => 'background: {{VALUE}}' ],
		],
		'snapster_title_paddings'    => [
			'type'      => 'responsive_spacing',
			'group'    => 'Title Typography',
			'heading'   => esc_html__( 'Title padding', 'snapster' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-cpt-article__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'snapster_term_paddings'    => [
			'type'      => 'responsive_spacing',
			'group'    => 'Term Typography',
			'heading'   => esc_html__( 'Term padding', 'snapster' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-cpt-article__terms' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'snapster_excerpt_paddings'    => [
			'type'      => 'responsive_spacing',
			'group'    => 'Snapster Excerpt Typography',
			'heading'   => esc_html__( 'Excerpt padding', 'snapster' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-cpt-article__excerpt' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'snapster_use_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for link?', 'snapster' ),
			'grid'    => 3,
		],
		'snapster_link_typo' => [
			'type'     => 'typography',
			'group'    => 'Snapster Link Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__link a',
		],
		'snapster_link_paddings'    => [
			'type'      => 'responsive_spacing',
			'group'    => 'Snapster Link Typography',
			'heading'   => esc_html__( 'Link padding', 'snapster' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-cpt-article__link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
	]);

}

function snapster_custom_post_types_skins_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['snapster_use_date_typo'] ) && ! empty( $shortcode->atts['snapster_date_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__terms'], $shortcode->parse_typography( $shortcode->atts['snapster_date_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['snapster_use_excerpt_typo'] ) && ! empty( $shortcode->atts['snapster_excerpt_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__excerpt'], $shortcode->parse_typography( $shortcode->atts['snapster_excerpt_typo'] ) );
	}

	if (! empty( $shortcode->atts['snapster_overlay_skin'] )  ) {
		$css['global']['%1$s .bg-overlay']['background'] = \Aheto\Sanitize::color( $shortcode->atts['snapster_overlay_skin'] );
	}

	if ( ! empty( $shortcode->atts['snapster_use_link_typo'] ) && ! empty( $shortcode->atts['snapster_link_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__link a'], $shortcode->parse_typography( $shortcode->atts['snapster_link_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'snapster_custom_post_types_skins_shortcode_dynamic_css', 10, 2 );
