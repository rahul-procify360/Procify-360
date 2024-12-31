<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_navbar_register', 'bizy_navbar_layout2' );




/**
 * Navbar
 */

function bizy_navbar_layout2( $shortcode ) {

	$preview_dir =  '//assets.aheto.co/navbar/previews/';

	$shortcode->add_layout( 'bizy_layout2', [
		'title' => esc_html__( 'Bizy Classic', 'bizy' ),
		'image' => $preview_dir . 'bizy_layout2.jpg',
	] );


    // bizy Simple
    $shortcode->add_dependecy( 'bizy_center_links', 'template', 'bizy_layout2' );
	$shortcode->add_dependecy( 'bizy_size', 'template', 'bizy_layout2');
	$shortcode->add_dependecy( 'bizy_use_link_typo', 'template', 'bizy_layout2'  );
	$shortcode->add_dependecy( 'bizy_link_typo', 'template', 'bizy_layout2' );
	$shortcode->add_dependecy( 'bizy_link_typo', 'bizy_use_link_typo', 'true' );


    $shortcode->add_params( [
        'bizy_center_links' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Links', 'bizy' ),
            'params'  => [
                'bizy_type_link'      => [
                    'type'    => 'select',
                    'heading' => esc_html__('Type of link', 'bizy'),
                    'options' => [
                        'bizy_socials'   => esc_html__('Social links', 'bizy'),
                        'bizy_searchbox'   => esc_html__('Searchbox', 'bizy'),
                        'bizy_languague'   => esc_html__('Languague select', 'bizy'),
                    ],
                ],            
            ],
		],
		'bizy_size'     => [
			'type'      => 'text',
			'heading'   => esc_html__( 'Size icon search', 'bizy' ),
			'grid'      => 6,
			'selectors' => [ '{{WRAPPER}} .aheto-navbar--item i.ion-ios-search-strong' => 'font-size: {{VALUE}}px' ],
			'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
		],
		'bizy_use_link_typo' => [
			'type'    => 'switch',
			'heading' => esc_html__( 'Use custom font for link?', 'bizy' ),
			'grid'    => 3,
		],
		'bizy_link_typo' => [
			'type'     => 'typography',
			'group'    => 'bizy link Typography',
			'settings' => [
				'tag'        => false,
				'text_align' => false,
			],
			'selector' => '{{WRAPPER}} .wpml-ls-native',
		],
    ] );


		\Aheto\Params::add_networks_params($shortcode, [
			'prefix' => 'bizy_links_',
			'dependency' => ['bizy_type_link', ['bizy_socials']]
		], 'bizy_center_links');

}
function bizy_navbar_layout2_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['bizy_use_link_typo'] ) && ! empty( $shortcode->atts['bizy_link_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .wpml-ls-native'], $shortcode->parse_typography( $shortcode->atts['bizy_link_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['bizy_size'] ) ) {
		$size = Sanitize::size( $shortcode->atts['bizy_size'] );
		$css['global']['%1$s .aheto-navbar--item i.ion-ios-search-strong']['size'] = $size;
	}

	return $css;
}

add_filter( 'aheto_navbar_dynamic_css', 'bizy_navbar_layout2_dynamic_css', 10, 2 );