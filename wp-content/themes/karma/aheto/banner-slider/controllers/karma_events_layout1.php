<?php

use Aheto\Helper;

add_action('aheto_before_aheto_banner-slider_register', 'karma_events_banner_slider_layout1');

/**
 *  Banner Slider
 */

function karma_events_banner_slider_layout1($shortcode) {

	$preview_dir = get_template_directory_uri() . '/aheto/banner-slider/previews/';

	$shortcode->add_layout('karma_events_layout1', [
		'title' => esc_html__('Famulus Simple', 'karma'),
		'image' => $preview_dir . 'karma_events_layout1.jpg',
	]);

	karma_add_dependency(['use_heading', 't_heading'], ['karma_events_layout1'], $shortcode);

	$shortcode->add_dependecy('karma_events_image_overlay', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_image_overlay', 'karma_events_overlay_img', 'true');
	$shortcode->add_dependecy('karma_events_overlay_img', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_banners', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_change_arrow_position', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_use_typo_contact', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_text_typo_contact', 'template', 'karma_events_layout1');
	$shortcode->add_dependecy('karma_events_text_typo_contact', 'karma_events_use_typo_contact', 'true');
	$shortcode->add_params([
		'karma_events_banners'               => [
			'type'    => 'group',
			'heading' => esc_html__('Banners', 'karma'),
			'params'  => [
				'karma_events_image'         => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'karma'),
				],
				'karma_events_title'         => [
					'type'    => 'textarea',
					'heading' => esc_html__('Title', 'karma'),

				],
				'karma_events_title_tag'     => [
					'type'    => 'select',
					'heading' => esc_html__('Element tag for Title', 'karma'),
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
					'grid'    => 5,
				],
				'karma_events_date'          => [
					'type'    => 'text',
					'heading' => esc_html__('Date', 'karma'),

				],
				'karma_events_place'         => [
					'type'    => 'text',
					'heading' => esc_html__('Place', 'karma'),

				],
				'karma_events_align'         => [
					'type'    => 'select',
					'heading' => esc_html__('Align', 'karma'),
					'options' => \Aheto\Helper::choices_alignment(),
				],
				'karma_events_btn_direction' => [
					'type'    => 'select',
					'heading' => esc_html__('Buttons Direction', 'karma'),
					'options' => [
						''            => esc_html__('Horizontal', 'karma'),
						'is-vertical' => esc_html__('Vertical', 'karma'),
					],
				],
				'karma_events_social'        => [
					'type'    => 'switch',
					'heading' => esc_html__('Add socials icons?', 'karma'),
					'grid'    => 12,
				],
			]
		],
		'karma_events_overlay_img'           => [
			'type'    => 'switch',
			'heading' => esc_html__('Enable overlay image for slider?', 'karma'),
			'grid'    => 12,
		],
		'karma_events_image_overlay'         => [
			'type'    => 'attach_image',
			'heading' => esc_html__('Overlay Image', 'karma')
		],
		'karma_events_change_arrow_position' => [
			'type'    => 'switch',
			'heading' => esc_html__('Change arrows position?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_use_typo_contact' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for contact?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_text_typo_contact'     => [
			'type'     => 'typography',
			'group'    => 'Karma Contact Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-banner__contact-item',
		],
	]);
	\Aheto\Params::add_button_params($shortcode, [
		'icons'      => true,
		'prefix' => 'karma_events_main_',
	], 'karma_events_banners');

	\Aheto\Params::add_button_params($shortcode, [
		'add_label' => esc_html__('Add additional button?', 'karma'),
		'icons'      => true,
		'prefix'    => 'karma_events_add_',
	], 'karma_events_banners');
	\Aheto\Params::add_networks_params($shortcode, [
		'prefix'     => 'karma_events_',
		'dependency' => ['karma_events_social', 'true']
	], 'karma_events_banners');
	\Aheto\Params::add_carousel_params($shortcode, [
		'custom_options' => true,
		'prefix'         => 'karma_events_swiper_simple_',
		'include'        => ['effect', 'speed', 'loop', 'autoplay', 'arrows'],
		'dependency'     => ['template', ['karma_events_layout1']]
	]);
}

function karma_events_banner_slider_layout1_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_events_use_typo_contact']) && $shortcode->atts['karma_events_use_typo_contact'] && isset($shortcode->atts['karma_events_text_typo_contact']) && !empty($shortcode->atts['karma_events_text_typo_contact']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-banner__contact-item'], $shortcode->parse_typography($shortcode->atts['karma_events_text_typo_contact']));
	}

	return $css;
}

add_filter('aheto_banner_slider_dynamic_css', 'karma_events_banner_slider_layout1_dynamic_css', 10, 2);