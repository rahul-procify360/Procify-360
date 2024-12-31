<?php

use Aheto\Helper;

add_action('aheto_before_aheto_contents_register', 'famulus_contents_layout6');


/**
 * Contents
 */

function famulus_contents_layout6($shortcode) {
	$preview_dir = '//assets.aheto.co/contents/previews/';
	$shortcode->add_layout('famulus_layout6', [
		'title' => esc_html__('Content 11', 'famulus'),
		'image' => $preview_dir . 'famulus_layout6.jpg',
	]);

	$shortcode->add_dependecy('famulus_simple_link', 'template', 'famulus_layout6');

	$shortcode->add_params([
		'famulus_simple_link' => [
			'type'    => 'group',
			'heading' => esc_html__('Item', 'famulus'),
			'params'  => [
				'famulus_title_simple'      => [
					'type'    => 'textarea',
					'heading' => esc_html__('Title', 'famulus'),
				],
				'famulus_title_tag_simple'  => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for title', 'famulus'),
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
					'default' => 'h3',
					'grid'    => 5,
				],
				'famulus_text'              => [
					'type'    => 'text',
					'heading' => esc_html__('Text', 'famulus'),
				],
				'famulus_link_title_simple' => [
					'type'    => 'text',
					'heading' => esc_html__('Link title', 'famulus'),
				],
				'famulus_link_url_simple'   => [
					'type'    => 'text',
					'heading' => esc_html__('Link Url', 'famulus'),
				],
			]
		]
	]);

}
