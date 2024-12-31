<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navigation_register', 'ewo_navigation_layout1' );

/**
 * Navigation
 */
function ewo_navigation_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout( 'ewo_layout1', [
		'title' => esc_html__( 'Navigation 4', 'ewo' ),
		'image' => $preview_dir . 'ewo_layout1.jpg',
	] );

	aheto_demos_add_dependency( 'transparent', [ 'ewo_layout1' ], $shortcode );
	
	$shortcode->add_dependecy('ewo_use_links_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_links_typo', 'template', 'ewo_layout1');
	$shortcode->add_dependecy('ewo_links_typo', 'ewo_use_links_typo', 'true');

	$shortcode->add_params([
		'ewo_use_links_typo' => [
			'type' => 'switch',
			'heading' => esc_html__('Use custom font for navigation?', 'ewo'),
			'grid' => 12,
			'default' => '',
		],
		'ewo_links_typo' => [
			'type' => 'typography',
			'group' => 'Ewo Navigation Typography',
			'settings' => [
				'text_align' => false,
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .main-menu li a',
		],
	]);
}

function ewo_navigation_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['ewo_use_links_typo'] ) && ! empty( $shortcode->atts['ewo_links_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .main-menu li a'], $shortcode->parse_typography( $shortcode->atts['ewo_links_typo'] ) );
    }
    return $css;
}

add_filter( 'aheto_navigation_dynamic_css', 'ewo_navigation_layout1_dynamic_css', 10, 2 );