<?php

use Aheto\Helper;

add_action('aheto_before_aheto_coming-soon_register', 'hryzantema_coming_soon_layout1');

/**
 * HR Consult Coming Soon
 */

function hryzantema_coming_soon_layout1($shortcode) {
	$preview_dir = '//assets.aheto.co/coming-soon/previews/';

	$shortcode->add_layout( 'hryzantema_layout1', [
		'title' => esc_html__( 'Coming Soon 4', 'hryzantema' ),
		'image' => $preview_dir . 'hryzantema_layout1.jpg',
	] );
	aheto_demos_add_dependency(['light','time','days_desktop','days_mobile','hours_desktop','hours_mobile','mins_desktop', 'mins_mobile','secs_desktop', 'secs_mobile'], ['hryzantema_layout1'], $shortcode);

	$shortcode->add_dependecy('hryzantema_use_units_text_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_units_text_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_units_text_typo', 'hryzantema_use_units_text_typo', 'true');

	$shortcode->add_dependecy('hryzantema_use_units_number_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_units_number_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_units_number_typo', 'hryzantema_use_units_number_typo', 'true');

	$shortcode->add_dependecy('hryzantema_use_dots_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_dots_typo', 'template', 'hryzantema_layout1');
	$shortcode->add_dependecy('hryzantema_dots_typo', 'hryzantema_use_dots_typo', 'true');

	$shortcode->add_params([
		'hryzantema_use_units_text_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font units text?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_units_text_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Units text typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-coming-soon__caption',
		],
		'hryzantema_use_units_number_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font units numbers?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_units_number_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Units numbers typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-coming-soon__number',
		],
		'hryzantema_use_dots_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font dots?', 'hryzantema' ),
			'grid'    => 3,
		],

		'hryzantema_dots_typo' => [
			'type'     => 'typography',
			'group'    => 'Hryzantema Dots typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
		],
	]);

}

function hryzantema_coming_soon_layout1_dynamic_css( $css, $shortcode ) {

	if ( isset( $shortcode->atts['hryzantema_use_dots_typo'] ) && $shortcode->atts['hryzantema_use_dots_typo'] && isset( $shortcode->atts['hryzantema_dots_typo'] ) && ! empty( $shortcode->atts['hryzantema_dots_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography( $shortcode->atts['hryzantema_dots_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_coming_soon_dynamic_css', 'hryzantema_coming_soon_layout1_dynamic_css', 10, 2 );

