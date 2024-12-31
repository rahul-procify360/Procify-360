<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'soapy_features_single_layout3');


/**
 * Feature Single
 */

function soapy_features_single_layout3($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('soapy_layout3', [
		'title' => esc_html__('Features Single 50', 'soapy'),
		'image' => $preview_dir . 'soapy_layout3.jpg',
	]);

	aheto_demos_add_dependency(['use_heading', 't_heading', 'use_description', 't_description'], ['soapy_layout3'], $shortcode);

    $shortcode->add_dependecy('soapy_title_tag', 'template', ['soapy_layout3']);
	$shortcode->add_dependecy('soapy_image_left', 'template', ['soapy_layout3']);
	$shortcode->add_dependecy('soapy_title', 'template', ['soapy_layout3']);
	$shortcode->add_dependecy('soapy_desc', 'template', ['soapy_layout3']);


	$shortcode->add_params([
		'soapy_image_left'  => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Before title image', 'soapy'),
		],
		'soapy_title'       => [
			'type'    => 'text',
			'heading' => esc_html__('Title', 'soapy'),
		],
		'soapy_desc'        => [
			'type'    => 'textarea',
			'heading' => esc_html__('Description', 'soapy'),
		],
        'soapy_title_tag' => [
            'type'    => 'select',
            'heading' => esc_html__('Title tag', 'soapy'),
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
	]);
}
