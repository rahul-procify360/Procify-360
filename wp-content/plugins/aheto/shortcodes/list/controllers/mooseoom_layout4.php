<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'mooseoom_list_layout4');

/**
 * List
 */

function mooseoom_list_layout4($shortcode)
{
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout('mooseoom_layout4', [
		'title' => esc_html__('List 11', 'mooseoom'),
		'image' => $dir . 'acacio_layout4.jpg',
	]);

	$shortcode->add_dependecy( 'mooseoom_disc', 'template', 'mooseoom_layout4' );
	$shortcode->add_dependecy('mooseoom_use_lists_typo', 'template', ['mooseoom_layout4']);
	$shortcode->add_dependecy('mooseoom_lists_typo', 'template', 'mooseoom_layout4');
	$shortcode->add_dependecy('mooseoom_lists_typo', 'mooseoom_use_lists_typo', 'true');

	aheto_demos_add_dependency( 'lists', [ 'mooseoom_layout4' ], $shortcode );

	$shortcode->add_params([
		'mooseoom_use_lists_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for list?', 'mooseoom'),
			'grid'    => 3,
		],

		'mooseoom_lists_typo' => [
			'type'     => 'typography',
			'group'    => 'Mooseoom List Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-list--mooseoom-links li a',
		],
		'mooseoom_disc'         => [
			'type'    => 'select',
			'heading' => esc_html__('Circle', 'mooseoom'),
			'options' => [
				''            => esc_html__('Off', 'mooseoom'),
				'disc-type' => esc_html__('On', 'mooseoom'),
			],
		],
	]);
}
function mooseoom_list_layout4_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['mooseoom_use_list_typo'] ) && ! empty( $shortcode->atts['mooseoom_list_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s li'], $shortcode->parse_typography( $shortcode->atts['mooseoom_list_typo'] ) );
	}
	return $css;
}

add_filter( 'aheto_list_dynamic_css', 'mooseoom_list_layout4_dynamic_css', 10, 2 );