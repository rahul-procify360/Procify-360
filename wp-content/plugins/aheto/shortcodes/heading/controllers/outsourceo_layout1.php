<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_heading_register', 'outsourceo_heading_layout1' );

/**
 * Heading Shortcode
 */
function outsourceo_heading_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'outsourceo_layout1', [
		'title' => esc_html__( 'Heading 17', 'outsourceo' ),
		'image' => $preview_dir . 'ninedok_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'outsourceo_align_tablet', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_align_mobile', 'template', 'outsourceo_layout1' );

	$shortcode->add_dependecy( 'outsourceo_subtitle', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_subtitle_tag', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_use_subtitle_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_use_dot', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_subtitle_typo', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_subtitle_typo', 'outsourceo_use_subtitle_typo', 'true' );

	$shortcode->add_dependecy( 'outsourceo_subtitle_bg_color', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_use_subtitle_bg_color', 'template', 'outsourceo_layout1' );
	$shortcode->add_dependecy( 'outsourceo_subtitle_bg_color', 'outsourceo_use_subtitle_bg_color', 'true' );

	aheto_demos_add_dependency( [ 'heading', 'alignment', 'source', 'text_tag', 'use_typo', 'text_typo'], [ 'outsourceo_layout1' ], $shortcode );

	$shortcode->add_params( [
		'outsourceo_subtitle'          => [
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Subtitle', 'outsourceo' ),
			'description' => esc_html__( 'Add some text for Subtitle', 'outsourceo' ),
			'admin_label' => true,
			'default'     => esc_html__( 'Add some text for Subtitle', 'outsourceo' ),
		],
		'outsourceo_subtitle_tag'      => [
			'type'    => 'select',
			'heading' => esc_html__( 'Element tag for Subtitle', 'outsourceo' ),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h5',
			'grid'    => 5,
		],
		'outsourceo_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for Subtitle?', 'outsourceo' ),
			'grid'    => 3,
		],

		'outsourceo_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Subtitle Typography',
			'settings' => [
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-heading__subtitle',
		],
		'outsourceo_use_subtitle_bg_color' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom colors for subtitle background?', 'outsourceo' ),
			'grid'    => 3,
		],
		'outsourceo_subtitle_bg_color' => [
			'type'      => 'colorpicker',
			'heading'   => esc_html__( 'Use custom color from colorpicker', 'outsourceo' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-heading__subtitle' => 'background-color: {{VALUE}}' ],
		],
		'outsourceo_use_dot'       => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use dot in the end of title?', 'outsourceo' ),
			'grid'    => 12,
		],
		'outsourceo_align_tablet' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align for tablet', 'outsourceo' ),
			'options' => [
				'default' => 'Default',
				'left'    => 'Left',
				'center'  => 'Center',
				'right'   => 'Right',
			],
			'default' => 'default',
		],
		'outsourceo_align_mobile' => [
			'type'    => 'select',
			'heading' => esc_html__( 'Align for mobile', 'outsourceo' ),
			'options' => [
				'default' => 'Default',
				'left'    => 'Left',
				'center'  => 'Center',
				'right'   => 'Right',
			],
			'default' => 'default',
		],

	] );

}

function outsourceo_heading_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['outsourceo_use_subtitle_typo'] ) && ! empty( $shortcode->atts['outsourceo_subtitle_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-heading__subtitle'], $shortcode->parse_typography( $shortcode->atts['outsourceo_subtitle_typo'] ) );
	}

	if (isset($shortcode->atts['outsourceo_use_subtitle_bg_color']) && $shortcode->atts['outsourceo_use_subtitle_bg_color'] && isset($shortcode->atts['outsourceo_subtitle_bg_color']) && !empty($shortcode->atts['outsourceo_subtitle_bg_color'])) {
		$color = Sanitize::color($shortcode->atts['outsourceo_subtitle_bg_color']);
		$css['global']['%1$s .aheto-heading__subtitle']['background-color'] = $color;
	}

	return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'outsourceo_heading_layout1_dynamic_css', 10, 2 );