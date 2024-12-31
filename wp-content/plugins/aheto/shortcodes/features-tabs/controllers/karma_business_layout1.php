<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-tabs_register', 'karma_business_features_tabs_layout1');

/**
* Navbar
*/

function karma_business_features_tabs_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/features-tabs/previews/';

    $shortcode->add_layout('karma_business_layout1', [
		'title' => esc_html__('Features Tabs 4', 'karma'),
		'image' => $preview_dir . 'karma_business_layout1.jpg',
	]);

	$shortcode->add_dependecy('karma_business_tabs', 'template', 'karma_business_layout1');
	
	$shortcode->add_dependecy('karma_business_use_title_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_title_typo', 'template', 'karma_business_layout1');
	$shortcode->add_dependecy('karma_business_title_typo', 'karma_business_use_title_typo', 'true');

	$shortcode->add_params([

		'karma_business_tabs'        => [
			'type'    => 'group',
			'heading' => esc_html__('Features Tabs', 'karma'),
			'params'  => [
				'karma_business_main_heading'     => [
					'type'    => 'text',
					'heading' => esc_html__('Tab Heading', 'karma'),
				],
				'karma_business_reverse'    => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Reverse content?', 'karma' ),
				],
				'karma_business_hidedivider'    => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Hide divider?', 'karma' ),
				],
				'karma_business_hideoverlay'    => [
					'type'    => 'switch',
					'heading' => esc_html__( 'Hide overlay?', 'karma' ),
				],
				'karma_business_title'     => [
					'type'    => 'text',
					'heading' => esc_html__('Content Title', 'karma'),
					'grid'    => 8,
				],
				'karma_business_title_tag' => [
					'type'    => 'select',
					'heading' => esc_html__('Content Title tag', 'karma'),
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
					'default' => 'h1',
					'grid'    => 2,
				],
								
				'karma_business_bg_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__( 'Background bg', 'karma' ),
				],
			],
		],

		'karma_business_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Title text?', 'karma'),
		],
		'karma_business_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Title Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-tabs__box-title',
		],

	]);

	\Aheto\Params::add_button_params($shortcode, [
		'prefix' => 'main_',
	], 'karma_business_tabs');

	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'aheto'),
		'prefix'    => 'add_',
	], 'karma_business_tabs');

}

function karma_business_features_tabs_shortcode_dynamic_css($css, $shortcode)  {

    if (!empty($shortcode->atts['karma_business_use_title_typo']) && !empty($shortcode->atts['karma_business_title_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-title'], $shortcode->parse_typography($shortcode->atts['karma_business_title_typo']));
    }
  
    return $css;

}

add_filter('aheto_features_tabs_dynamic_css', 'karma_business_features_tabs_shortcode_dynamic_css', 10, 2);