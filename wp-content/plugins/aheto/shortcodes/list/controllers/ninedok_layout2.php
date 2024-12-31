<?php

use Aheto\Helper;

add_action ( 'aheto_before_aheto_list_register', 'ninedok_list_layout2' );

/**
 * List
 */

function ninedok_list_layout2 ( $shortcode )
{
	$dir = '//assets.aheto.co/list/previews/';

	$shortcode -> add_layout ( 'ninedok_layout2', [
		'title' => esc_html__ ( 'List 17', 'ninedok' ),
		'image' => $dir . 'acacio_layout4.jpg',
	] );

	$shortcode -> add_dependecy ( 'ninedok_use_list_item_typo', 'template', 'ninedok_layout2' );
	$shortcode -> add_dependecy ( 'ninedok_list_item_typo', 'template', 'ninedok_layout2' );
	$shortcode -> add_dependecy ( 'ninedok_list_item_typo', 'ninedok_use_list_item_typo', 'true' );
	$shortcode -> add_dependecy ( 'ninedok_color', 'template', 'ninedok_layout2' );
	aheto_demos_add_dependency ( 'lists', [ 'ninedok_layout2' ], $shortcode );


	$shortcode -> add_params ( [
		'ninedok_use_list_item_typo' => [
			'type' => 'switch',
			'heading' => esc_html__ ( 'Use custom font for list?', 'ninedok' ),
			'grid' => 3,
		],
		'ninedok_list_item_typo' => [
			'type' => 'typography',
			'group' => 'Ninedok List Typography',
			'settings' => [
				'tag' => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-list--bullets-ninedok li',
		],
		'ninedok_color' => [
			'type' => 'colorpicker',
			'heading' => esc_html__ ( 'Color Bullet', 'ninedok' ),
			'grid' => 6,
			'selectors' => [
				'{{WRAPPER}} .aheto-list--bullets li::before' => 'background-color: {{VALUE}}',
				'{{WRAPPER}} .aheto-list--number[data-index]::before' => 'color: {{VALUE}}',
				'{{WRAPPER}} .aheto-list--bullets li::after' => 'background-color: {{VALUE}}',
				'{{WRAPPER}} .aheto-list--number[data-index]::after' => 'color: {{VALUE}}',
			],
		],
	] );
}

function ninedok_list_layout2_dynamic_css ( $css, $shortcode )
{
	if ( !empty( $shortcode -> atts['ninedok_use_list_item_typo'] ) && !empty( $shortcode -> atts['ninedok_list_item_typo'] )) {
		\aheto_add_props ( $css['global']['%1$s .aheto-list--bullets-ninedok li'], $shortcode -> parse_typography ( $shortcode -> atts['ninedok_list_item_typo'] ) );
	}
	if ( !empty( $shortcode -> atts['ninedok_color'] )) {
		$color = Sanitize ::color ( $shortcode -> atts['ninedok_color'] );
		$css['global']['%1$s .aheto-list--bullets li::before']['background-color'] = $color;
		$css['global']['%1$s .aheto-list--number[data-index]::before']['color'] = $color;
		$css['global']['%1$s .aheto-list--bullets li::after']['background-color'] = $color;
		$css['global']['%1$s .aheto-list--number[data-index]::after']['color'] = $color;
	}

	return $css;
}

add_filter ( 'aheto_list_dynamic_css', 'ninedok_list_layout2_dynamic_css', 10, 2 );