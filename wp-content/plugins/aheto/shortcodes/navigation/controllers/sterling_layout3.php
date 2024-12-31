<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navigation_register', 'sterling_navigation_layout3');

/**
 * Navigation
 */

function sterling_navigation_layout3($shortcode)
{

	$dir = '//assets.aheto.co/navigation/previews/';

	$shortcode->add_layout('sterling_layout3', [
		'title' => esc_html__('Sterling Navigation footer', 'sterling'),
		'image' => $dir . 'sterling_layout3.jpg',
	]);

  
	$shortcode->add_dependecy('sterling_use_links_typo', 'template', ['sterling_layout3']);
	$shortcode->add_dependecy('sterling_links_typo', 'template', ['sterling_layout3']);
	$shortcode->add_dependecy('sterling_links_typo', 'sterling_use_links_typo', 'true');


	$shortcode->add_params([
		'sterling_use_links_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for links?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_links_typo' => [
			'type'     => 'typography',
			'group'    => 'Navigation Links Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .main-menu li a',
		]
	]);
}