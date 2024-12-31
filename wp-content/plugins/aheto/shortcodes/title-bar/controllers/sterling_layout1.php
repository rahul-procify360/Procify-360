<?php

use Aheto\Helper;

add_action('aheto_before_aheto_title-bar_register', 'sterling_title_bar_layout1');

/**
 * Title Bar
 */

function sterling_title_bar_layout1($shortcode)
{
	$theme_dir = '//assets.aheto.co/title-bar/previews/';
	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling Classic', 'sterling'),
		'image' => $theme_dir . 'sterling_layout1.jpg',
	]);
	
	$shortcode->add_dependecy('sterling_use_title_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_title_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_title_typo', 'sterling_use_title_typo', 'true');
	$shortcode->add_dependecy('sterling_use_arrow_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_arrow_typo', 'sterling_use_arrow_typo', 'true');

	aheto_demos_add_dependency('use_title_typo', ['sterling_layout1'], $shortcode);

	$shortcode->add_params([
		'sterling_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for breadcrumbs?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Breadcrumbs Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aht-breadcrumbs__item',
		],
		'sterling_use_arrow_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font-size for arrow?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_arrow_typo' => [
			'type'     => 'typography',
			'group'    => 'Arrow Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aht-breadcrumbs__item:before',
		],
	]);
}