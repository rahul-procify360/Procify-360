<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'outsourceo_custom_post_types_skins' );

/**
 * Custom Post Type Shortcode
 */

function outsourceo_custom_post_types_skins( $shortcode ) {


	$shortcode->add_dependecy( 'outsourceo_img_off', 'skin', 'outsourceo_skin-1' );
	$shortcode->add_dependecy( 'outsourceo_use_dot', 'skin', ['outsourceo_skin-1', 'outsourceo_skin-3'] );
	$shortcode->add_dependecy( 'outsourceo_use_author_typo', 'skin', ['outsourceo_skin-1', 'outsourceo_skin-3']);
	$shortcode->add_dependecy( 'outsourceo_author_typo', 'skin', ['outsourceo_skin-1', 'outsourceo_skin-3']);
	$shortcode->add_dependecy( 'outsourceo_author_typo', 'outsourceo_use_author_typo', 'true' );
	$shortcode->add_dependecy( 'outsourceo_add_borderradius', 'skin', 'outsourceo_skin-2' );

	$shortcode->add_dependecy( 'outsourceo_paddings', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_background', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_background_hover', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_border_color', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_border_color_hover', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_title_hover', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_author_hover', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_desc_hover', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_term_hover', 'skin', 'outsourceo_skin-3' );
	$shortcode->add_dependecy( 'outsourceo_terms_bg', 'skin', 'outsourceo_skin-3' );

	$shortcode->add_dependecy( 'outsourceo_use_desc_typo', 'skin', ['outsourceo_skin-3']);
	$shortcode->add_dependecy( 'outsourceo_desc_typo', 'skin', ['outsourceo_skin-3']);
	$shortcode->add_dependecy( 'outsourceo_desc_typo', 'outsourceo_use_desc_typo', 'true' );

	// CUSTOM SKIN 1

	$aheto_skins      = $shortcode->params['skin']['options'];
	$outsourceo_skins = array(
		'outsourceo_skin-1' => 'Outsourceo skin 1',
		'outsourceo_skin-2' => 'Outsourceo skin 2',
		'outsourceo_skin-3' => 'Outsourceo skin 3',
	);

	$shortcode->add_params( [
		'outsourceo_img_off' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Disable post image?', 'outsourceo' ),
			'grid'    => 12,
		],
		'outsourceo_use_dot'       => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot at the end of the title?', 'outsourceo' ),
			'grid'    => 12,
		],
		'outsourceo_use_author_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for author?', 'outsourceo' ),
			'grid'    => 6,
		],

		'outsourceo_author_typo' => [
			'type'     => 'typography',
			'group'    => 'Outsourceo Author Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__author',
		],
		'outsourceo_add_borderradius' => [
			'type'    => 'switch',
			'heading' => esc_html__('Add border radius on hover', 'outsourceo')
		],
		'outsourceo_paddings'    => [
			'type'      => 'responsive_spacing',
			'heading'   => esc_html__( 'Block padding', 'aheto' ),
			'grid'      => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-cpt-article__content, {{WRAPPER}} .aht-breadcrumbs--only' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		],
		'outsourceo_background' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Background color', 'aheto' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__content' => 'background: {{VALUE}}', '{{WRAPPER}} .aheto-cpt-article__terms a' => 'background: {{VALUE}}' ],
		],
		'outsourceo_background_hover' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Background color on hover', 'aheto' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__inner:hover .aheto-cpt-article__content' => 'background: {{VALUE}}' ],
		],
		'outsourceo_terms_bg' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Disable background color from Terms', 'aheto' ),
			'grid'    => 6,
		],
		'outsourceo_border_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Border color', 'aheto' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__content' => 'border-color: {{VALUE}}', '{{WRAPPER}} .aheto-cpt-article__footer .aheto-cpt-article__author' => 'border-color: {{VALUE}}' ],
		],
		'outsourceo_border_color_hover' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Border color on hover', 'aheto' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__inner:hover .aheto-cpt-article__content' => 'border-color: {{VALUE}}', '{{WRAPPER}} .aheto-cpt-article__inner:hover .aheto-cpt-article__footer .aheto-cpt-article__author' => 'border-color: {{VALUE}}' ],
		],
		'outsourceo_title_hover' => [
			'type' => 'colorpicker',
			'group'    => 'Title Typography',
			'heading' => esc_html__ ( 'Color hover', 'aheto' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__content:hover .aheto-cpt-article__title' => 'color: {{VALUE}}' ],
		],
		'outsourceo_author_hover' => [
			'type' => 'colorpicker',
			'group'    => 'Author Typography',
			'heading' => esc_html__ ( 'Color hover', 'aheto' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__content:hover .aheto-cpt-article__author' => 'color: {{VALUE}}' ],
		],
		'outsourceo_desc_hover' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Color hover', 'aheto' ),
			'group'    => 'Description Typography',
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__content:hover .aheto-cpt-article__excerpt p' => 'color: {{VALUE}}' ],
		],
		'outsourceo_term_hover' => [
			'type' => 'colorpicker',
			'group'    => 'Term Typography',
			'heading' => esc_html__ ( 'Color hover', 'aheto' ),
			'grid' => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-cpt-article__content:hover .aheto-cpt-article__terms' => 'color: {{VALUE}}' ],
		],
		'outsourceo_use_desc_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Description', 'aheto' ),
			'grid'    => 6,
		],

		'outsourceo_desc_typo' => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__excerpt p',
		],
	] );

	$all_skins                            = array_merge( $aheto_skins, $outsourceo_skins );
	$shortcode->params['skin']['options'] = $all_skins;

}


function outsourceo_cpt_skins_shortcode_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_author_typo'] ) && ! empty( $shortcode->atts['outsourceo_author_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__author'], $shortcode->parse_typography( $shortcode->atts['outsourceo_author_typo'] ) );
	}

	if ( isset( $shortcode->atts['outsourceo_background'] ) && !empty($shortcode->atts['outsourceo_background'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__content']['background'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_background'] );
		$css['global']['%1$s .aheto-cpt-article__terms a']['background'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_background'] );
	}
	if ( isset( $shortcode->atts['outsourceo_background_hover'] ) && !empty($shortcode->atts['outsourceo_background_hover'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__inner:hover .aheto-cpt-article__contentt']['background'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_background_hover'] );
	}

	if ( isset( $shortcode->atts['outsourceo_border_color'] ) && !empty($shortcode->atts['outsourceo_border_color'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__content']['border-color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_border_color'] );
		$css['global']['%1$s .aheto-cpt-article__footer .aheto-cpt-article__author']['border-color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_border_color'] );
	}

	if ( isset( $shortcode->atts['outsourceo_border_color_hover'] ) && !empty($shortcode->atts['outsourceo_border_color_hover'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__inner .aheto-cpt-article__content']['border-color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_border_color_hover'] );
		$css['global']['%1$s .aheto-cpt-article__inner .aheto-cpt-article__footer .aheto-cpt-article__author']['border-color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_border_color_hover'] );
	}

	if ( isset( $shortcode->atts['outsourceo_title_hover'] ) && !empty($shortcode->atts['outsourceo_title_hover'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__content:hover .aheto-cpt-article__title']['color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_title_hover'] );
	}

	if ( isset( $shortcode->atts['outsourceo_author_hover'] ) && !empty($shortcode->atts['outsourceo_author_hover'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__content:hover .aheto-cpt-article__author']['color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_author_hover'] );
	}

	if ( isset( $shortcode->atts['outsourceo_desc_hover'] ) && !empty($shortcode->atts['outsourceo_desc_hover'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__content:hover .aheto-cpt-article__excerpt p']['color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_desc_hover'] );
	}

	if ( isset( $shortcode->atts['outsourceo_term_hover'] ) && !empty($shortcode->atts['outsourceo_term_hover'] ) ) {
		$css['global']['%1$s .aheto-cpt-article__content:hover .aheto-cpt-article__terms']['color'] = \Aheto\Sanitize::color( $shortcode->atts['outsourceo_term_hover'] );
	}

	if ( isset($shortcode->atts['outsourceo_use_desc_typo']) && $shortcode->atts['outsourceo_use_desc_typo'] && isset($shortcode->atts['outsourceo_desc_typo']) && !empty($shortcode->atts['outsourceo_desc_typo']) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__excerpt p'], $shortcode->parse_typography( $shortcode->atts['outsourceo_desc_typo'] ) );
	}


	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'outsourceo_cpt_skins_shortcode_dynamic_css', 10, 2 );