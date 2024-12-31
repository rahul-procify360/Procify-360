<?php

use Aheto\Helper;

add_action('aheto_before_aheto_media_register', 'funero_media_layout1');

/**
 * Media member
 */

function funero_media_layout1($shortcode) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout('funero_layout1', [
		'title' => esc_html__('Media 6', 'funero'),
		'image' => $preview_dir . 'funero_layout1.jpg',
	]);

	$shortcode->add_dependecy('funero_gallery', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_smaller_block', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_name_use_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_name_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_name_typo', 'funero_name_use_typo', 'true');
	$shortcode->add_dependecy('funero_date_use_typo', 'template', ['funero_layout1']);
	$shortcode->add_dependecy('funero_date_typo', 'template', 'funero_layout1');
	$shortcode->add_dependecy('funero_date_typo', 'funero_date_use_typo', 'true');

	$shortcode->add_params([
		'funero_gallery'        => [
			'type'    => 'group',
			'heading' => esc_html__('Gallery', 'funero'),
			'params'  => [
				'funero_image' => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Image', 'funero'),
				],
				'funero_link'  => [
					'type'    => 'link',
					'heading' => esc_html__('Link', 'funero'),
				],
				'funero_name'  => [
					'type'    => 'text',
					'heading' => esc_html__('Name', 'funero'),
				],
				'funero_date'  => [
					'type'    => 'text',
					'heading' => esc_html__('Date', 'funero'),
				],
			],
		],
		'funero_smaller_block'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Smaller item?', 'funero'),
			'grid'    => 3,
		],
		'funero_name_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Name?', 'funero'),
			'grid'    => 3,
		],
		'funero_name_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Name Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-funero-gallery__name',
		],
		'funero_date_use_typo'  => [
			'type'    => 'switch',
			'heading' => esc_html__('Use custom font for Date?', 'funero'),
			'grid'    => 3,
		],
		'funero_date_typo'      => [
			'type'     => 'typography',
			'group'    => 'Funero Date Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => true,
			],
			'selector' => '{{WRAPPER}} .aheto-funero-gallery__date',
		],

	]);

	\Aheto\Params::add_image_sizer_params($shortcode, [
		'group'    => 'Funero Image',
		'prefix'     => 'funero_media_',
		'dependency' => ['template', ['funero_layout1']]
	]);

}

function funero_media_layout1_dynamic_css($css, $shortcode) {
	if ( isset($shortcode->atts['funero_name_use_typo']) && $shortcode->atts['funero_name_use_typo'] && isset($shortcode->atts['funero_name_typo']) && !empty($shortcode->atts['funero_name_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-funero-gallery__name'], $shortcode->parse_typography($shortcode->atts['funero_name_typo']));
	}
	if ( isset($shortcode->atts['funero_date_use_typo']) &&  $shortcode->atts['funero_date_use_typo'] && isset($shortcode->atts['funero_date_typo']) && !empty($shortcode->atts['funero_date_typo']) ) {
		\aheto_add_props($css['global']['%1$s .aheto-funero-gallery__date'], $shortcode->parse_typography($shortcode->atts['funero_date_typo']));
	}

	return $css;
}
add_filter('aheto_media_dynamic_css', 'funero_media_layout1_dynamic_css', 10, 2);
