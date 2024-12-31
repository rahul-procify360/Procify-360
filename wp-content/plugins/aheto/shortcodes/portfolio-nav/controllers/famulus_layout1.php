<?php

use Aheto\Helper;

add_action('aheto_before_aheto_portfolio-nav_register', 'famulus_portfolio_nav_layout1');

/**
 * Portfolio Nav Shortcode
 */
function famulus_portfolio_nav_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/portfolio-nav/previews/';
	$shortcode->add_layout('famulus_layout1', [
		'title' => esc_html__('Portfolio Nav 2', 'famulus'),
		'image' => $preview_dir . 'famulus_layout1.jpg',
	]);
	$shortcode->add_dependecy('famulus_prev_next', 'template', 'famulus_layout1');
	$shortcode->add_params([
		'famulus_prev_next' => [
			'type'    => 'text',
			'heading' => esc_html__('Text near "Prev" "Next" links', 'famulus'),
		],
	]);
}