<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_twitter_register', 'karma_political_twitter_layout1' );

/**
 * Twitter
 */

function karma_political_twitter_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/twitter/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Twitter 1', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
	] );

	$shortcode->add_dependecy( 'karma_political_desc', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_hash', 'template', 'karma_political_layout1' );
	$shortcode->add_dependecy( 'karma_political_link', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_dropdown_icon_color', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_dropdown_icon_size', 'template', 'karma_political_layout1' );

    $shortcode->add_dependecy( 'karma_political_use_desc_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_desc_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_desc_typo', 'karma_political_use_desc_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_hash_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_hash_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_hash_typo', 'karma_political_use_hash_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_link_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_link_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_link_typo', 'karma_political_use_link_typo', 'true' );

    $shortcode->add_params( [

	    'karma_political_desc'          => [
	        'type'        => 'textarea',
	        'heading'     => esc_html__( 'Description', 'karma' ),
	        'description' => esc_html__( 'Add some text for description', 'karma' ),
	        'admin_label' => true,
	        'default'     => esc_html__( 'Add some text for description', 'karma' ),
	    ],
	    'karma_political_hash'          => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Hashtag', 'karma' ),
            'description' => esc_html__( 'Add some text for hashtag', 'karma' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Add some text for hashtag', 'karma' ),
        ],
        'karma_political_link'          => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Link', 'karma' ),
            'description' => esc_html__( 'Add some link', 'karma' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Add some link', 'karma' ),
        ],

	    'karma_political_use_description_typo' => [
	        'type'    => 'switch',
	        'heading' => esc_html__( 'Use custom font for description?', 'karma' ),
	        'grid'    => 3,
	    ],
	    'karma_political_description_typo'     => [
	        'type'     => 'typography',
	        'group'    => 'Description Typography',
	        'settings' => [
	            'tag'        => false,
	            'text_align' => true,
	        ],
	        'selector' => '{{WRAPPER}} .aheto-twitter--desc',
	    ],

	    'karma_political_use_hash_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for hashtag?', 'karma' ),
            'grid'    => 3,
        ],
        'karma_political_hash_typo'     => [
            'type'     => 'typography',
            'group'    => 'Hashtag Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-twitter--hash',
        ],

        'karma_political_use_link_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for link?', 'karma' ),
            'grid'    => 3,
        ],
        'karma_political_link_typo'     => [
            'type'     => 'typography',
            'group'    => 'Link Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-twitter--link',
        ],

        'karma_political_dropdown_icon_color'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Twitter Icon Color', 'noize' ),
            'selectors' => [
                '{{WRAPPER}} .aheto-twitter--icon::before' => 'color: {{VALUE}}',
            ],
        ],
        'karma_political_dropdown_icon_size'   => [
            'type'     => 'text',
            'heading'   => esc_html__( 'Twitter Icon Size', 'noize' ),
            'selectors' => [
                '{{WRAPPER}} .aheto-twitter--icon::before' => 'font-size: {{VALUE}};',
            ],
        ],

	] );

}

function karma_political_twitter_layout1_dynamic_css( $css, $shortcode ) {

	if ( ! empty( $shortcode->atts['karma_political_use_desc_typo'] ) && ! empty( $shortcode->atts['karma_political_desc_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-twitter--desc'], $shortcode->parse_typography( $shortcode->atts['karma_political_desc_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['karma_political_use_hash_typo'] ) && ! empty( $shortcode->atts['karma_political_hash_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-twitter--hash'], $shortcode->parse_typography( $shortcode->atts['karma_political_hash_typo'] ) );
	}

	if ( ! empty( $shortcode->atts['karma_political_use_link_typo'] ) && ! empty( $shortcode->atts['karma_political_link_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-twitter--link'], $shortcode->parse_typography( $shortcode->atts['karma_political_link_typo'] ) );
	}

    if (isset($shortcode->atts['karma_political_dropdown_icon_color']) && !empty($shortcode->atts['karma_political_dropdown_icon_color'])) {
        $css['global']['%1$s .aheto-twitter--icon::before']['color'] = \Aheto\Sanitize::color($shortcode->atts['karma_political_dropdown_icon_color']);
    }

	return $css;

}

add_filter( 'aheto_twitter_dynamic_css', 'karma_political_twitter_layout1_dynamic_css', 10, 2 );