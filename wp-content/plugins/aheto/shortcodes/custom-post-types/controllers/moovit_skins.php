<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_custom-post-types_register', 'moovit_custom_post_types_skins' );

/**
 * Custom Post Type
 */

function moovit_custom_post_types_skins( $shortcode ) {

	$aheto_skins  = $shortcode->params['skin']['options'];
	$aheto_addon_skins = array(
		'moovit_skin-1' => 'Moovit skin 1',
		'moovit_skin-2' => 'Moovit skin 2',
		'moovit_skin-3' => 'Moovit skin 3',
		'moovit_skin-4' => 'Moovit skin 4',
		'moovit_skin-5' => 'Moovit skin 5'
	);

	$all_skins = array_merge( $aheto_skins, $aheto_addon_skins );


	$shortcode->params['skin']['options'] = $all_skins;


	$shortcode->add_dependecy( 'moovit_dot', 'skin', [ 'moovit_skin-1', 'moovit_skin-2', 'moovit_skin-3', 'moovit_skin-4', 'moovit_skin-5' ] );
	$shortcode->add_dependecy( 'moovit_dot_color', 'skin', [
		'moovit_skin-1',
		'moovit_skin-2',
		'moovit_skin-3',
		'moovit_skin-4',
		'moovit_skin-5'
	] );

	$shortcode->add_dependecy( 'moovit_link_text', 'skin', ['moovit_skin-2', 'moovit_skin-3']);
	$shortcode->add_dependecy( 'moovit_link_icon', 'skin', ['moovit_skin-2', 'moovit_skin-3']);
	$shortcode->add_dependecy( 'moovit_link_underline', 'skin', ['moovit_skin-2', 'moovit_skin-3']);
	$shortcode->add_dependecy( 'moovit_link_color', 'skin', ['moovit_skin-2', 'moovit_skin-3']);
	$shortcode->add_dependecy( 'moovit_link_color_hover', 'skin', ['moovit_skin-2', 'moovit_skin-3'] );
	$shortcode->add_dependecy( 'moovit_dot_color', 'moovit_dot', 'true' );
	$shortcode->add_dependecy( 'moovit_hide_author', 'skin', 'moovit_skin-3');
	$shortcode->add_dependecy( 'moovit_use_author', 'skin', ['moovit_skin-1', 'moovit_skin-3'] );
	$shortcode->add_dependecy( 'moovit_t_author', 'skin', ['moovit_skin-1', 'moovit_skin-3'] );
	$shortcode->add_dependecy( 'moovit_t_author', 'moovit_use_author', 'true' );
	$shortcode->add_dependecy( 'moovit_avatar_size', 'skin', ['moovit_skin-3']);


	$shortcode->add_params( [
		'moovit_dot' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot at the end of the title?', 'moovit' ),
			'grid'    => 12,
		],

		'moovit_dot_color' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Color for dot', 'moovit' ),
			'options' => [
				'primary' => esc_html__( 'Primary', 'moovit' ),
				'dark'    => esc_html__( 'Dark', 'moovit' ),
				'white'   => esc_html__( 'White', 'moovit' ),
			],
			'default' => 'primary',
		],

		'moovit_link_text' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Text for view more link', 'moovit' ),
			'default' => 'View Case Study',
		],
		'moovit_link_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Color for view more link', 'moovit' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-link.aheto-btn--dark' => 'color: {{VALUE}}' ],
		],
		'moovit_link_color_hover' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Hover color for view more link', 'moovit' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-link.aheto-btn--dark:hover' => 'color: {{VALUE}}' ],
		],
        'moovit_link_icon'    => [
            'type'        => 'switch',
            'heading'     => esc_html__( 'Remove icon from view more link?', 'aheto' ),
            'grid'        => 3,
        ],
        'moovit_link_underline'    => [
            'type'        => 'switch',
            'heading'     => esc_html__( 'Add underline to view more link?', 'aheto' ),
            'grid'        => 3,
        ],
		'moovit_use_author'    => [
			'type'        => 'switch',
			'heading'     => esc_html__( 'Use custom font for author?', 'aheto' ),
			'description' => esc_html__( 'It works for skins that have a author.', 'aheto' ),
			'grid'        => 3,
		],
		'moovit_hide_author'    => [
			'type'        => 'switch',
			'heading'     => esc_html__( 'Hide author name?', 'aheto' ),
			'grid'        => 3,
			'default'   => false,
		],
		'moovit_t_author'      => [
			'type'     => 'typography',
			'group'    => 'Moovit Author Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-cpt-article__author',
		],
		'moovit_avatar_size' => [
			'type'    => 'text',
			'heading' => esc_html__( 'Author avatar size', 'moovit' ),
			'default' => '30',
		]
	]);

}


function moovit_skins_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['moovit_use_author'] ) && ! empty( $shortcode->atts['moovit_t_author'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-cpt-article__author'], $shortcode->parse_typography( $shortcode->atts['moovit_t_author'] ) );
	}

	if ( isset( $shortcode->atts['moovit_link_color'] ) && !empty($shortcode->atts['moovit_link_color'] ) ) {
		$css['global']['%1$s .aheto-link.aheto-btn--dark']['color'] = \Aheto\Sanitize::color( $shortcode->atts['moovit_link_color'] );
	}

	if ( isset( $shortcode->atts['moovit_link_color_hover'] ) && !empty($shortcode->atts['moovit_link_color_hover'] ) ) {
		$css['global']['%1$s .aheto-link.aheto-btn--dark:hover']['color'] = \Aheto\Sanitize::color( $shortcode->atts['moovit_link_color_hover'] );
	}

	return $css;
}

add_filter( 'aheto_cpt_dynamic_css', 'moovit_skins_dynamic_css', 10, 2 );
