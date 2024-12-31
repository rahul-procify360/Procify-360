<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'funero_navigation_layout2');

/**
 *  Navigation Shortcode
 */

/**
 * Navigation Shortcode
 */
function funero_navigation_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('funero_layout2', [
		'title' => esc_html__('Navigation 8', 'funero'),
		'image' => $preview_dir . 'funero_layout2.jpg',
	]);


	$shortcode->add_dependecy('funero_use_menu_link_typo', 'template', ['funero_layout2']);
	$shortcode->add_dependecy('funero_menu_link_typo', 'template', 'funero_layout2');
	$shortcode->add_dependecy('funero_menu_link_typo', 'funero_use_menu_link_typo', 'true');


	$shortcode->add_params([

		'funero_use_menu_link_typo'      => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for menu links?', 'funero'),
			'grid'    => 3,
		],
		'funero_menu_link_typo'          => [
			'type'     => 'typography',
			'group'    => 'Funero Menu links Typography',
			'settings' => [
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .menu-home-page-container .menu-item a',
		],
	]);

}

function funero_navigation_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['funero_use_menu_link_typo']) &&  $shortcode->atts['funero_use_menu_link_typo'] && isset($shortcode->atts['funero_menu_link_typo']) && !empty($shortcode->atts['funero_menu_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .menu-home-page-container .menu-item a'], $shortcode->parse_typography($shortcode->atts['funero_menu_link_typo']));
	}
	return $css;
}

add_filter('aheto_navigation_dynamic_css', 'funero_navigation_layout2_dynamic_css', 10, 2);
