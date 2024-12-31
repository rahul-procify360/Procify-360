<?php

use Aheto\Helper;

add_action('aheto_before_aheto_coming-soon_register', 'ewo_coming_soon_layout1');

/**
 *  Banner Slider
 */

function ewo_coming_soon_layout1($shortcode)
{

  $preview_dir = '//assets.aheto.co/coming-soon/previews/';

  $shortcode->add_layout('ewo_layout1', [
    'title' => esc_html__('Coming Soon 3', 'ewo'),
    'image' => $preview_dir . 'ewo_layout1.jpg',
  ]);

	aheto_demos_add_dependency(['light', 'time', 'days_desktop', 'days_mobile', 'hours_desktop', 'hours_mobile', 'mins_desktop', 'mins_mobile', 'secs_desktop', 'secs_mobile' ], ['ewo_layout1'], $shortcode);

	$shortcode->add_dependecy('ewo_use_number_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_number_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_number_typo', 'ewo_use_number_typo', 'true');

	$shortcode->add_dependecy('ewo_use_caption_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_caption_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_caption_typo', 'ewo_use_caption_typo', 'true');

	$shortcode->add_dependecy('ewo_use_dots_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_dots_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_dots_typo', 'ewo_use_dots_typo', 'true');
	
	$shortcode->add_params([
		'ewo_use_number_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for numbers?', 'ewo'),
			'grid'    => 3,
		],

		'ewo_number_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Numbers Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-coming-soon__number',
		],
		'ewo_use_caption_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for caption?', 'ewo'),
			'grid'    => 3,
		],

		'ewo_caption_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Caption Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-coming-soon__caption',
		],
		'ewo_use_dots_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for dots?', 'ewo'),
			'grid'    => 3,
		],

		'ewo_dots_typo' => [
			'type'     => 'typography',
			'group'    => 'Ewo Dots Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-coming-soon__dots',
		],
	]);
}

function ewo_coming_soon_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['ewo_use_number_typo'] ) && ! empty( $shortcode->atts['ewo_number_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-coming-soon__number'], $shortcode->parse_typography( $shortcode->atts['ewo_number_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['ewo_use_caption_typo'] ) && ! empty( $shortcode->atts['ewo_caption_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-coming-soon__caption'], $shortcode->parse_typography( $shortcode->atts['ewo_caption_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['ewo_use_dots_typo'] ) && ! empty( $shortcode->atts['ewo_dots_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-coming-soon__dots'], $shortcode->parse_typography( $shortcode->atts['ewo_dots_typo'] ) );
	}

	return $css;
}