<?php

use Aheto\Helper;

add_action('aheto_before_aheto_navbar_register', 'karma_business_navbar_layout1');

/**
* Navbar
*/

function karma_business_navbar_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

    $shortcode->add_layout('karma_business_layout1', [
		'title' => esc_html__('Navbar 8', 'karma'),
		'image' => $preview_dir . 'karma_business_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_business_search', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_max_width', 'template', 'karma_business_layout1');

	$shortcode->add_dependecy('karma_business_use_justtext_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_justtext_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_justtext_typo', 'karma_business_use_justtext_typo', 'true');

	aheto_demos_add_dependency( [ 'remove_borders', 'columns', 'right_links', 'right_hide_mobile', 'left_links', 'left_hide_mobile', 'use_links_typo', 'links_typo', 'use_socials_typo', 'socials_typo' ], [ 'karma_business_layout1' ], $shortcode);

    $shortcode->add_params([

		'karma_business_search'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Searchbox', 'karma'),
		],
		'karma_business_max_width'          => [
			'type'      => 'slider',
			'heading'   => esc_html__('Max width for navbar', 'karma'),
			'grid'      => 12,
			'range'     => [
				'px' => [
					'min'  => 0,
					'max'  => 3000,
					'step' => 5,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .aheto-navbar--wrap' => 'max-width: {{SIZE}}{{UNIT}};',
			],
		],

		'karma_business_use_justtext_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Just text?', 'karma'),
		],
		'karma_business_justtext_typo' => [
			'type'     => 'typography',
			'group'    => 'Justtext Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-navbar--item-label',
		],

	]);
}

function karma_business_navbar_shortcode_dynamic_css($css, $shortcode) {

    if (!empty($shortcode->atts['karma_business_use_justtext_typo']) && !empty($shortcode->atts['karma_business_justtext_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-navbar--item-label'], $shortcode->parse_typography($shortcode->atts['karma_business_justtext_typo']));
    }
  
    return $css;

}

add_filter('aheto_navbar_dynamic_css', 'karma_business_navbar_shortcode_dynamic_css', 10, 2);
