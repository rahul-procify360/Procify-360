<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_contents_register', 'ewo_contents_layout4' );

/**
 * Contents
 */

function ewo_contents_layout4( $shortcode ) {

	$preview_dir = '//assets.aheto.co/contents/previews/';

	$shortcode->add_layout( 'ewo_layout4', [
		'title' => esc_html__( 'Content 5', 'ewo' ),
		'image' => $preview_dir . 'ewo_layout4.jpg',
	] );

  $shortcode->add_dependecy('ewo_gallery_brands', 'template', 'ewo_layout4');

  $shortcode->add_dependecy('ewo_use_category_typo', 'template', 'ewo_layout4');
	$shortcode->add_dependecy('ewo_category_typo', 'template', 'ewo_layout4');
	$shortcode->add_dependecy('ewo_category_typo', 'ewo_use_category_typo', 'true');
  
  $shortcode->add_params([
		'ewo_gallery_brands' => [
			'type'    => 'group',
			'heading' => esc_html__('Ewo Consult Gallery Items', 'ewo'),
			'params'  => [
				'ewo_gallery_heading'    => [
					'type'    => 'text',
					'heading' => esc_html__('Category', 'ewo'),
					'default' => esc_html__('Enter your text...', 'ewo'),
				],
				'ewo_gallery_img'        => [
					'type'    => 'attach_image',
					'heading' => esc_html__('Item Image', 'ewo'),
				],
				'ewo_gallery_size'    => [
					'type'    => 'select',
					'heading' => esc_html__('Double width or height', 'ewo'),
					'options' => [
						''  => esc_html__('default', 'ewo'),
						'aheto-gallery-brands--ibw-2'  => esc_html__('2x-width', 'ewo'),
						'aheto-gallery-brands--ibh-2' => esc_html__('2x-height', 'ewo'),
					]
				],
			],
		],

		'ewo_use_category_typo' => [
			'type' => 'switch',
			'heading' => esc_html__('Use custom font for category?', 'ewo'),
			'grid' => 12,
			'default' => '',
		],

		'ewo_category_typo' => [
			'type' => 'typography',
			'group' => 'Ewo Category Typography',
			'settings' => [
				'text_align' => false,
				'tag'        => false,
			],
			'selector' => '{{WRAPPER}} .aheto-gallery-brands__list-link',
		],

	]);
}

function ewo_contents_layout4_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['ewo_use_category_typo'] ) && ! empty( $shortcode->atts['ewo_category_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-gallery-brands__list-link'], $shortcode->parse_typography( $shortcode->atts['ewo_category_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_contents_dynamic_css', 'ewo_contents_layout4_dynamic_css', 10, 2 );