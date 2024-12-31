<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'karma_business_features_single_layout2');


/**
 * Navbar
 */


function karma_business_features_single_layout2($shortcode)
{

	$preview_dir = '//assets.aheto.co/features-single/previews/';

	$shortcode->add_layout('karma_business_layout2', [
		'title' => esc_html__('Features Single 27', 'karma'),
		'image' => $preview_dir . 'karma_business_layout2.jpg',
	]);

	aheto_demos_add_dependency( [ 's_heading', 'use_heading', 't_heading' ], ['karma_business_layout2'], $shortcode);

	$shortcode->add_dependecy('karma_business_subtitle', 'template', 'karma_business_layout2');
	$shortcode->add_dependecy('karma_business_phone', 'template', 'karma_business_layout2');
    $shortcode->add_dependecy('karma_business_title_tag', 'template', 'karma_business_layout2');
    $shortcode->add_dependecy('karma_business_subtitle_tag', 'template', 'karma_business_layout2');

	$shortcode->add_dependecy('karma_business_use_title_typo', 'template', 'karma_business_layout2');
	$shortcode->add_dependecy('karma_business_title_typo', 'template', 'karma_business_layout2');
	$shortcode->add_dependecy('karma_business_title_typo', 'karma_business_use_title_typo', 'true');
	
	$shortcode->add_dependecy('karma_business_use_subtitle_typo', 'template', 'karma_business_layout2');
	$shortcode->add_dependecy('karma_business_subtitle_typo', 'template', 'karma_business_layout2');
	$shortcode->add_dependecy('karma_business_subtitle_typo', 'karma_business_use_subtitle_typo', 'true');
	
	$shortcode->add_dependecy('karma_business_use_phone_typo', 'template', 'karma_business_layout2');
	$shortcode->add_dependecy('karma_business_phone_typo', 'template', 'karma_business_layout2');
	$shortcode->add_dependecy('karma_business_phone_typo', 'karma_business_use_phone_typo', 'true');

	$shortcode->add_params([
		'karma_business_subtitle' => [
			'type'    => 'text',
			'heading' => esc_html__('Subtitle', 'karma'),
			'default' => 'Subtutle',
			'grid'    => 4,
		],
		'karma_business_use_subtitle_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Subtitle?', 'karma'),
			'grid'    => 5,
		],
		'karma_business_subtitle_typo' => [
			'type'     => 'typography',
			'group'    => 'Business Subtitle Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-single__subtitle',
		],
		'karma_business_subtitle_tag' => [
			'type'    => 'select',
			'heading' => esc_html__('Subtitle tag', 'karma'),
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
			'default' => 'h6',
			'grid'    => 5,
		],
		'karma_business_title_tag' => [
			'type'    => 'select',
			'heading' => esc_html__('Heading tag', 'karma'),
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
			'default' => 'h2',
			'grid'    => 2,
		],
		'karma_business_use_title_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Heading text?', 'karma'),
			'grid'    => 3,
		],
		'karma_business_title_typo' => [
			'type'     => 'typography',
			'group'    => 'Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-features-single__title',
		],
		'karma_business_phone'       => [
			'type'    => 'text',
			'heading' => esc_html__( 'Phone', 'aheto' ),
		],
		'karma_business_use_phone_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Phone?', 'karma'),
			'grid'    => 6,
		],
		'karma_business_phone_typo' => [
			'type'     => 'typography',
			'group'    => 'Business Phone Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-features-single__tel',
		],

	]);

	\Aheto\Params::add_button_params($shortcode, [
		'add_button' => true,
		'prefix' => 'karma_business_main_',
		'icons' => true,
		'align' => true,
		'dependency' => ['template', 'karma_business_layout2']
	]);

	\Aheto\Params::add_icon_params($shortcode, [
		'add_icon' => true,
		'exclude'  => ['align'],
		'dependency' => ['template', ['karma_business_layout2']]
	]);
}
function karma_business_features_single_layout2_dynamic_css($css, $shortcode)
{
	if (!empty($shortcode->atts['karma_business_use_title_typo']) && !empty($shortcode->atts['karma_business_title_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-title'], $shortcode->parse_typography($shortcode->atts['karma_business_title_typo']));
	}
	if (!empty($shortcode->atts['karma_business_use_subtitle_typo']) && !empty($shortcode->atts['karma_business_subtitle_typo'])) {
		\aheto_add_props($css['global']['%1$s .aheto-features-tabs__box-subtitle'], $shortcode->parse_typography($shortcode->atts['karma_business_subtitle_typo']));
	}
	if (!empty($shortcode->atts['karma_business_use_phone_typo']) && !empty($shortcode->atts['karma_business_phone_typo'])) {
		\aheto_add_props($css['global']['%1$s .features-single__tel'], $shortcode->parse_typography($shortcode->atts['karma_business_phone_typo']));
	}

	return $css;
}
add_filter('aheto_features_tabs_dynamic_css', 'karma_business_features_single_layout2_dynamic_css', 10, 2);
