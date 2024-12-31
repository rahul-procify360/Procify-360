<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'acacio_navbar_layout1' );


/**
 * Navbar
 */

function acacio_navbar_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'acacio_layout1', [
		'title' => esc_html__( 'Navbar 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout1.jpg',
	] );


    // Acacio Simple
    $shortcode->add_dependecy( 'acacio_center_links', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_label', 'acacio_type_link', ['acacio_custom', 'acacio_phone', 'acacio_email', 'acacio_text'] );
    $shortcode->add_dependecy( 'acacio_phone', 'acacio_type_link', 'acacio_phone' );
    $shortcode->add_dependecy( 'acacio_email', 'acacio_type_link', 'acacio_email' );
    $shortcode->add_dependecy( 'acacio_add_icon', 'acacio_type_link', ['acacio_phone','acacio_email'] );
    $shortcode->add_dependecy( 'acacio_type_icon', 'template', 'acacio_layout1' );
    $shortcode->add_dependecy( 'acacio_type_icon', 'acacio_add_icon', 'true' );
    $shortcode->add_dependecy( 'acacio_custom_link', 'acacio_type_link', 'acacio_custom' );
	$shortcode->add_dependecy(  'acacio_size', 'template', 'acacio_layout1');
	$shortcode->add_dependecy( 'acacio_use_link_typo', 'template', 'acacio_layout1'  );
	$shortcode->add_dependecy( 'acacio_link_typo', 'template', 'acacio_layout1' );
	$shortcode->add_dependecy( 'acacio_link_typo', 'acacio_use_link_typo', 'true' );


    $shortcode->add_params( [
        'acacio_center_links' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Center column links', 'acacio' ),
            'params'  => [
                'acacio_type_link'      => [
                    'type'    => 'select',
                    'heading' => esc_html__('Type of link', 'acacio'),
                    'options' => [
                        'acacio_phone' => esc_html__('Phone', 'acacio'),
                        'acacio_email'   => esc_html__('Email', 'acacio'),
                        'acacio_custom_link'   => esc_html__('Custom link', 'acacio'),
                        'acacio_text'   => esc_html__('Just text', 'acacio'),
                        'acacio_socials'   => esc_html__('Social links', 'acacio'),
                        'acacio_searchbox'   => esc_html__('Searchbox', 'acacio'),
                        'acacio_languague'   => esc_html__('Languague picker', 'acacio'),
                    ],
                ],
                'acacio_add_icon'        => [
                    'type'    => 'switch',
                    'heading' => esc_html__( 'Add icon before label?', 'acacio' ),
                    'grid'    => 6,
                    'default' => '',
                ],
                'acacio_type_icon'      => [
                    'type'    => 'select',
                    'heading' => esc_html__('Type of icon', 'acacio'),
                    'options' => [
                        '' => esc_html__('Solid', 'acacio'),
                        '-outline'   => esc_html__('Outline', 'acacio'),
                    ],
                ],
                'acacio_label'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Label', 'acacio' ),
                ],
                'acacio_phone'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Phone', 'acacio' ),
                ],
                'acacio_email'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Email', 'acacio' ),
                ],
                'acacio_custom_link'         => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Link', 'acacio' ),
                ],
	            'acacio_size'     => [
		            'type'      => 'text',
		            'heading'   => esc_html__( 'Size icon search', 'acacio' ),
		            'grid'      => 6,
		            'selectors' => [ '{{WRAPPER}} .aheto-navbar--item i.ion-ios-search-strong' => 'font-size: {{VALUE}}px' ],
		            'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
	            ],
	            'acacio_use_link_typo' => [
		            'type'    => 'switch',
		            'heading' => esc_html__( 'Use custom font for link?', 'acacio' ),
		            'grid'    => 3,
	            ],
	            'acacio_link_typo' => [
		            'type'     => 'typography',
		            'group'    => 'Acacio Link Typography',
		            'settings' => [
			            'tag'        => false,
			            'text_align' => false,
		            ],
		            'selector' => '{{WRAPPER}} .wpml-ls-native',
	            ],
            ],
        ],
    ] );

}
function acacio_navbar_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['acacio_use_link_typo'] ) && ! empty( $shortcode->atts['acacio_link_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .wpml-ls-native'], $shortcode->parse_typography( $shortcode->atts['acacio_link_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['acacio_size'] ) ) {
		$size = Sanitize::size( $shortcode->atts['acacio_size'] );
		$css['global']['%1$s .aheto-navbar--item i.ion-ios-search-strong']['size'] = $size;
	}

	return $css;
}

add_filter( 'aheto_navbar_dynamic_css', 'acacio_navbar_layout1_dynamic_css', 10, 2 );