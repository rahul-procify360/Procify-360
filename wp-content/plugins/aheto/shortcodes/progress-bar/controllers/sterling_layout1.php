<?php

use Aheto\Helper;

add_action('aheto_before_aheto_progress-bar_register', 'sterling_progress_bar_layout1');

/**
 * Progress Bar Shortcode
 */

function sterling_progress_bar_layout1($shortcode)
{
	$theme_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout('sterling_layout1', [
		'title' => esc_html__('Sterling Modern', 'sterling'),
		'image' => $theme_dir . 'sterling_layout1.jpg',
	]);

	$shortcode->add_dependecy('sterling_number', 'template', ['sterling_layout1']);
	$shortcode->add_dependecy('sterling_use_number_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_number_typo', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_number_typo', 'sterling_use_number_typo', 'true');
	
	$shortcode->add_dependecy('sterling_symbol', 'template', ['sterling_layout1' ] );
	$shortcode->add_dependecy('sterling_use_symbol_typo', 'template', ['sterling_layout1' ] );
	$shortcode->add_dependecy('sterling_symbol_typo', 'template', ['sterling_layout1' ] );
	$shortcode->add_dependecy('sterling_symbol_typo', 'sterling_use_symbol_typo', 'true');

	$shortcode->add_dependecy('sterling_title', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_title_tag', 'template', 'sterling_layout1');
	$shortcode->add_dependecy('sterling_title_typo', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_use_title_typo', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_title_typo', 'sterling_use_title_typo', 'true');

	$shortcode->add_params([
		'sterling_number'    => [
			'type'    => 'text',
			'heading' => esc_html__('Number', 'sterling'),
		],
		'sterling_use_number_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Number?', 'sterling'),
			'grid'    => 6,
		],
		'sterling_number_typo'   => [
			'type'     => 'typography',
			'group'    => 'Sterling Number Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__number',
		],
		'sterling_symbol'    => [
			'type'    => 'text',
			'heading' => esc_html__( 'Symbol after Symbol', 'sterling' ),
		],
		'sterling_use_symbol_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Symbol?', 'sterling'),
			'grid'    => 6,
		],
		'sterling_symbol_typo'   => [
			'type'     => 'typography',
			'group'    => 'Sterling Symbol Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-counter__symbol',
		],
		'sterling_title'    => [
			'type'    => 'textarea',
			'heading' => esc_html__('Title', 'sterling'),
		],
		'sterling_title_tag' => [
			'type'    => 'select',
			'heading' => esc_html__('Element tag for Title', 'sterling'),
			'options' => [
				'h1'  => 'h1',
				'h2'  => 'h2',
				'h3'  => 'h3',
				'h4'  => 'h4',
				'h5'  => 'h5',
				'h6'  => 'h6',
				'p'   => 'p',
				'div' => 'div',
			],
			'default' => 'h4',
			'grid'    => 1,
		],
		'sterling_use_title_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title?', 'sterling'),
			'grid'    => 6,
		],
		'sterling_title_typo'   => [
			'type'     => 'typography',
			'group'    => 'Sterling Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-progress__title',
		],
	]);
}