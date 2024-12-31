<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_features-timeline_register', 'mooseoom_features_timeline_layout1' );


/**
 * Features Timeline Shortcode
 */

function mooseoom_features_timeline_layout1( $shortcode ) {
	$dir = '//assets.aheto.co/features-timeline/previews/';

	$shortcode->add_layout( 'mooseoom_layout1', [
		'title' => esc_html__( 'Features Timeline 3', 'mooseoom' ),
		'image' => $dir . 'acacio_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'mooseoom_timeline', 'template', 'mooseoom_layout1' );
	$shortcode->add_dependecy( 'mooseoom_dark_version', 'template', 'mooseoom_layout1' );

	$shortcode->add_dependecy( 'mooseoom_use_date_typo', 'template', 'mooseoom_layout1' );
	$shortcode->add_dependecy( 'mooseoom_date_typo', 'template', 'mooseoom_layout1' );
	$shortcode->add_dependecy( 'mooseoom_date_typo', 'mooseoom_use_date_typo', 'true' );
	
	$shortcode->add_dependecy( 'mooseoom_use_activedate_typo', 'template', 'mooseoom_layout1' );
	$shortcode->add_dependecy( 'mooseoom_activedate_typo', 'template', 'mooseoom_layout1' );
	$shortcode->add_dependecy( 'mooseoom_activedate_typo', 'mooseoom_use_activedate_typo', 'true' );


	$shortcode->add_params( [
		'mooseoom_use_date_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for date?', 'mooseoom' ),
			'grid'    => 3,
		],

		'mooseoom_date_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-timeline__events a h5',
		],
		'mooseoom_use_activedate_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for active date?', 'mooseoom' ),
			'grid'    => 3,
		],

		'mooseoom_activedate_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom Active Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-timeline__events a.selected h5',
		],
		'mooseoom_timeline' => [
			'type'    => 'group',
			'heading' => esc_html__( 'Items', 'mooseoom' ),
			'params'  => [
				'mooseoom_timeline_date'       => [
					'type'    => 'text',
					'heading' => esc_html__( 'Date', 'mooseoom' ),
				],
				'mooseoom_timeline_title'        => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Title', 'mooseoom' ),
					'description' => esc_html__( 'To Hightlight text insert text between: [[ Your Text Here ]]', 'mooseoom' ),
					'default'     => esc_html__( 'Title with [[ hightlight ]] text.', 'mooseoom' ),
				],
				'mooseoom_timeline_content'        => [
					'type'    => 'textarea',
					'heading' => esc_html__( 'Content', 'mooseoom' ),
					'default' => esc_html__( 'Add some text for content', 'mooseoom' ),
				],
				'mooseoom_timeline_image'     => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Add image', 'mooseoom' ),
				],
			],
		],

		'mooseoom_dark_version'    => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Enable dark version?', 'mooseoom' ),
			'grid'    => 3,
		],
	] );

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'prefix'         => 'mooseoom_',
		'dependency' => ['template',  ['mooseoom_layout1']]
	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'mooseoom_',
		'icons'      => true,
	], 'mooseoom_timeline');
}
function mooseoom_features_timeline_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['mooseoom_use_date_typo'] ) && ! empty( $shortcode->atts['mooseoom_date_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-timeline__events a h5'], $shortcode->parse_typography( $shortcode->atts['mooseoom_date_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['mooseoom_use_activedate_typo'] ) && ! empty( $shortcode->atts['mooseoom_activedate_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-timeline__events a.selected'], $shortcode->parse_typography( $shortcode->atts['mooseoom_activedate_typo'] ) );
	}
	
	return $css;
}

add_filter( 'aheto_features_timeline_dynamic_css', 'mooseoom_features_timeline_layout1_dynamic_css', 10, 2 );