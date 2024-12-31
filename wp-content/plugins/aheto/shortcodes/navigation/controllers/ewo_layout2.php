<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'ewo_navigation_layout2' );

/**
 * Navigation
 */
function ewo_navigation_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'ewo_layout2', [
		'title' => esc_html__( 'Navigation 5', 'ewo' ),
		'image' => $preview_dir . 'ewo_layout2.jpg',
	] );

	aheto_demos_add_dependency( ['logo', 'mob_logo', 'mobile_menu_width'], [ 'ewo_layout2' ], $shortcode );

	$shortcode->add_dependecy('ewo_use_close_typo', 'template', 'ewo_layout2');
	$shortcode->add_dependecy('ewo_close_typo', 'template', 'ewo_layout2');
	$shortcode->add_dependecy('ewo_close_typo', 'ewo_use_close_typo', 'true');

	$shortcode->add_params([
		'ewo_use_close_typo' => [
			'type' => 'switch',
			'heading' => esc_html__('Use custom font for arrow?', 'ewo'),
			'grid' => 12,
			'default' => '',
		],
		'ewo_close_typo' => [
			'type' => 'typography',
			'group' => 'Ewo Arrow Typography',
			'settings' => [
				'text_align' => false,
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .btn-close i',
		],
	]);
}

function ewo_navigation_layout2_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['ewo_use_close_typo'] ) && ! empty( $shortcode->atts['ewo_close_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .btn-close i'], $shortcode->parse_typography( $shortcode->atts['ewo_close_typo'] ) );
    }
    return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'ewo_navigation_layout2_dynamic_css', 10, 2 );