<?php

use Aheto\Helper;

add_action('aheto_before_aheto_clients_register', 'famulus_clients_layout1');

/**
 *  Banner Slider
 */

function famulus_clients_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/clients/previews/';

	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Clients 2', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);

	$shortcode->add_dependecy('famulus_max_width', 'template', 'famulus_layout1');

	aheto_demos_add_dependency(['hover_style', 'clients', 'item_per_row' ], ['famulus_layout1'], $shortcode);

	$shortcode->add_params([
		'famulus_max_width' => [
			'type'      => 'slider',
			'heading'   => esc_html__('Max width for image section', 'famulus'),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 5,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-clients__wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		],

	]);

}

function famulus_clients_layout1_dynamic_css($css, $shortcode) {


	if ( !empty($shortcode->atts['famulus_max_width']) ) {

		$css['global']['%1$s .aheto-clients__wrapper']['width'] = Sanitize::size($shortcode->atts['max_width']);
	}

	return $css;
}

add_filter('aheto_clients_dynamic_css', 'famulus_clients_layout1_dynamic_css', 10, 2);


