<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-single_register', 'karma_events_features_single_layout2');


/**
 * Feature Single
 */

function karma_events_features_single_layout2($shortcode) {
	$preview_dir = '//assets.aheto.co/features-single/previews/';
	$shortcode->add_layout('karma_events_layout2', [
		'title' => esc_html__('Features Single 29', 'karma'),
		'image' => $preview_dir . 'karma_events_layout2.jpg',
	]);

	aheto_demos_add_dependency(['s_heading', 's_description'], ['karma_events_layout2'], $shortcode);

	$shortcode->add_dependecy('karma_events_image', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_address', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_price', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_price_text', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_link_title', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_link_url', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_title_use_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_title_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_title_typo', 'karma_events_title_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_desc_use_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_desc_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_desc_typo', 'karma_events_desc_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_link_use_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_link_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_link_typo', 'karma_events_link_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_price_use_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_price_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_price_typo', 'karma_events_price_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_price_label_use_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_price_label_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_price_label_typo', 'karma_events_price_label_use_typo', 'true');
	$shortcode->add_dependecy('karma_events_address_use_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_address_typo', 'template', 'karma_events_layout2');
	$shortcode->add_dependecy('karma_events_address_typo', 'karma_events_address_use_typo', 'true');
	$shortcode->add_params([
		'karma_events_image'                => [
			'type'        => 'attach_image',
			'heading'     => esc_html__('Image', 'karma'),
			'admin_label' => true,
		],
		'karma_events_address'              => [
			'type'    => 'text',
			'heading' => esc_html__('Address', 'karma'),
		],
		'karma_events_price'                => [
			'type'    => 'text',
			'heading' => esc_html__('Price', 'karma'),
		],
		'karma_events_price_text'           => [
			'type'    => 'text',
			'heading' => esc_html__('Price Text', 'karma'),
		],
		'karma_events_link_title'           => [
			'type'    => 'text',
			'heading' => esc_html__('Link Title', 'karma'),
		],
		'karma_events_link_url'             => [
			'type'    => 'text',
			'heading' => esc_html__('Link URL', 'karma'),
		],
		'karma_events_title_use_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for heading?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_title_typo'           => [
			'type'     => 'typography',
			'group'    => 'Heading Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__title',
		],
		'karma_events_desc_use_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Description?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_desc_typo'            => [
			'type'     => 'typography',
			'group'    => 'Description Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__info-text',
		],
		'karma_events_link_use_typo'        => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Link?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_link_typo'            => [
			'type'     => 'typography',
			'group'    => 'Link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__link',
		],
		'karma_events_price_use_typo'       => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_price_typo'           => [
			'type'     => 'typography',
			'group'    => 'Price Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__content-price ',
		],
		'karma_events_price_label_use_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for price label?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_price_label_typo'     => [
			'type'     => 'typography',
			'group'    => 'Price Label Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__content-price-text ',
		],
		'karma_events_address_use_typo'     => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for address?', 'karma'),
			'grid'    => 3,
		],
		'karma_events_address_typo'         => [
			'type'     => 'typography',
			'group'    => 'Address Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .aheto-content-block__info-address ',
		],
	]);

}

function karma_events_features_single_layout2_dynamic_css($css, $shortcode) {

	if ( isset($shortcode->atts['karma_events_title_use_typo']) && $shortcode->atts['karma_events_title_use_typo'] && isset($shortcode->atts['karma_events_title_typo']) && !empty($shortcode->atts['karma_events_title_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__title'], $shortcode->parse_typography($shortcode->atts['karma_events_title_typo']));
	}
	if ( isset($shortcode->atts['karma_events_desc_use_typo']) && $shortcode->atts['karma_events_desc_use_typo'] && isset($shortcode->atts['karma_events_desc_typo']) && !empty($shortcode->atts['karma_events_desc_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__info-text'], $shortcode->parse_typography($shortcode->atts['karma_events_desc_typo']));
	}
	if ( isset($shortcode->atts['karma_events_link_use_typo']) && $shortcode->atts['karma_events_link_use_typo'] && isset($shortcode->atts['karma_events_link_typo']) && !empty($shortcode->atts['karma_events_link_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__link'], $shortcode->parse_typography($shortcode->atts['karma_events_link_typo']));
	}
	if ( isset($shortcode->atts['karma_events_price_use_typo']) && $shortcode->atts['karma_events_price_use_typo'] && isset($shortcode->atts['karma_events_price_typo']) && !empty($shortcode->atts['karma_events_price_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__content-price '], $shortcode->parse_typography($shortcode->atts['karma_events_price_typo']));
	}
	if ( isset($shortcode->atts['karma_events_price_label_use_typo']) && $shortcode->atts['karma_events_price_label_use_typo'] && isset($shortcode->atts['karma_events_price_label_typo']) && !empty($shortcode->atts['karma_events_price_label_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__content-price-text '], $shortcode->parse_typography($shortcode->atts['karma_events_price_label_typo']));
	}
	if ( isset($shortcode->atts['karma_events_address_use_typo']) && $shortcode->atts['karma_events_address_use_typo'] && isset($shortcode->atts['karma_events_address_typo']) && !empty($shortcode->atts['karma_events_address_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-content-block__info-address'], $shortcode->parse_typography($shortcode->atts['karma_events_address_typo']));
	}

	return $css;
}

add_filter('aheto_features_single_dynamic_css', 'karma_events_features_single_layout2_dynamic_css', 10, 2);

