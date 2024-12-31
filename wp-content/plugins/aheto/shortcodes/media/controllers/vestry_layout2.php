<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_media_register', 'vestry_media_layout2' );


/**
 * Media Shortcode
 */

function vestry_media_layout2( $shortcode ) {

	$preview_dir = '//assets.aheto.co/media/previews/';

	$shortcode->add_layout( 'vestry_layout2', [
		'title' => esc_html__( 'Media 23', 'vestry' ),
		'image' => $preview_dir . 'vestry_layout2.jpg',
	] );

	$shortcode->add_dependecy( 'vestry_all_item', 'template', [ 'vestry_layout2' ] );
	$shortcode->add_dependecy( 'vestry_image', 'template', 'vestry_layout2' );

	$shortcode->add_dependecy( 'desktop_spaces', 'template', 'vestry_layout2' );
	$shortcode->add_dependecy( 'tablet_spaces', 'template', 'vestry_layout2' );
	$shortcode->add_dependecy( 'mobile_spaces', 'template', 'vestry_layout2' );

	$shortcode->add_params( [
		'vestry_image'    => [
			'type'    => 'attach_images',
			'heading' => esc_html__( 'Add image', 'vestry' ),
		],
		'vestry_all_item' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Show all images?', 'vestry' ),
			'grid'    => 3,
		],
		'desktop_spaces'          => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Desktop Spaces', 'aheto' ),
			'default'   => 40,
			'value'     => 40,
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-vestry-gallery-img' => '--desktop-spaces: {{VALUE}}' ],
		],
		'tablet_spaces'          => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Tablet Spaces', 'aheto' ),
			'default'   => 20,
			'value'     => 20,
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-vestry-gallery-img' => '--tablet-spaces: {{VALUE}}' ],
		],
		'mobile_spaces'          => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Tablet Spaces', 'aheto' ),
			'default'   => 15,
			'value'     => 15,
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-vestry-gallery-img' => '--mobile-spaces: {{VALUE}}' ],
		],
	] );

	\Aheto\Params::add_image_sizer_params( $shortcode, [
		'group'      => esc_html__( 'Images size', 'vestry' ),
		'prefix'     => 'vestry_',
		'dependency' => [ 'template', [ 'vestry_layout2' ] ]
	] );
}




function vestry_media_layout2_dynamic_css( $css, $shortcode ) {

	if ( $shortcode->isSpacesValid( $shortcode->atts['desktop_spaces'] ) ) {
		$css['global']['%1$s .aheto-vestry-gallery-img']['--desktop-spaces'] = $shortcode->atts['desktop_spaces'];
	}

	if ( $shortcode->isSpacesValid( $shortcode->atts['tablet_spaces'] ) ) {
		$css['global']['%1$s .aheto-vestry-gallery-img']['--tablet-spaces'] = $shortcode->atts['tablet_spaces'];
	}

	if ( $shortcode->isSpacesValid( $shortcode->atts['mobile_spaces'] ) ) {
		$css['global']['%1$s .aheto-vestry-gallery-img']['--mobile-spaces'] = $shortcode->atts['mobile_spaces'];
	}

	return $css;
}

add_filter( 'aheto_media_dynamic_css', 'vestry_media_layout2_dynamic_css', 10, 2 );