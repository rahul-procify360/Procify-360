<?php

use Aheto\Helper;

add_action('aheto_before_aheto_list_register', 'sterling_list_layout3');

/**
 * List
 */

function sterling_list_layout3($shortcode)
{

	$dir = '//assets.aheto.co/list/previews/';

	$shortcode->add_layout('sterling_layout3', [
		'title' => esc_html__('Sterling list with bigger number', 'sterling'),
		'image' => $dir . 'sterling_layout3.jpg',
	]);

	aheto_demos_add_dependency('heading', ['sterling_layout3'], $shortcode);
	aheto_demos_add_dependency('text_tag', ['sterling_layout3'], $shortcode);
	aheto_demos_add_dependency('description', ['sterling_layout3'], $shortcode);
	aheto_demos_add_dependency('index', ['sterling_layout3'], $shortcode);

	$shortcode->add_dependecy('sterling_use_num_typo', 'template', ['sterling_layout3']);
	$shortcode->add_dependecy('sterling_num_typo', 'template', ['sterling_layout3']);
	$shortcode->add_dependecy('sterling_num_typo', 'sterling_use_num_typo', 'true');

	$shortcode->add_params([
		'sterling_use_num_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for numbers?', 'sterling'),
			'grid'    => 3,
		],
		'sterling_num_typo' => [
			'type'     => 'typography',
			'group'    => 'Numbers Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .sterling-list--number[data-index]::before'
		],
	]);
}