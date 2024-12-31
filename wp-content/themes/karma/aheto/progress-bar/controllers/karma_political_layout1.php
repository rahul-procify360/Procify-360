<?php

use Aheto\Helper;

add_action( 'aheto_before_aheto_progress-bar_register', 'karma_political_progress_bar_layout1' );

/**
 * Progress Bar Shortcode
 */

function karma_political_progress_bar_layout1( $shortcode ) {

	$preview_dir = get_template_directory_uri() . '/aheto/progress-bar/previews/';

	$shortcode->add_layout( 'karma_political_layout1', [
		'title' => esc_html__( 'Karma progress-bar', 'karma' ),
		'image' => $preview_dir . 'karma_political_layout1.jpg',
    ] );
    
    $shortcode->add_dependecy( 'karma_political_image', 'template', 'karma_political_layout1' );

    $shortcode->add_dependecy( 'karma_political_use_counter_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_counter_typo', 'karma_political_use_counter_typo', 'true' );

    $shortcode->add_dependecy( 'karma_political_use_description_typo', 'template', 'karma_political_layout1' );
    $shortcode->add_dependecy( 'karma_political_description_typo', 'karma_political_use_description_typo', 'true' );
  
	karma_add_dependency( 'percentage', [ 'karma_political_layout1' ], $shortcode );
	karma_add_dependency( 'description', [ 'karma_political_layout1' ], $shortcode );
	
	$shortcode->add_params( [
        'karma_political_image'     => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Image', 'karma' ),
        ],
        'karma_political_use_counter_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for counter?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_counter_typo'     => [
            'type'     => 'typography',
            'group'    => 'Counter Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__number ',
        ],
        'karma_political_use_description_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for description?', 'karma'),
            'grid'    => 3,
        ],
        'karma_political_description_typo'     => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-counter__desc ',
        ],
    ] );
	
	\Aheto\Params::add_image_sizer_params($shortcode, [
        'prefix'     => 'karma_political_',
        'dependency' => [ 'template', [ 'karma_political_layout1' ] ]
    ] );
	
}


function karma_political_progress_bar_layout1_dynamic_css( $css, $shortcode ) {
	if ( ! empty( $shortcode->atts['karma_political_use_counter_typo'] ) && ! empty( $shortcode->atts['karma_political_counter_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__number'], $shortcode->parse_typography( $shortcode->atts['karma_political_subtitle_typo'] ) );
	}
	if ( ! empty( $shortcode->atts['karma_political_use_description_typo'] ) && ! empty( $shortcode->atts['karma_political_description_typo'] ) ) {
		\aheto_add_props( $css['global']['%1$s .aheto-counter__desc'], $shortcode->parse_typography( $shortcode->atts['karma_political_description_typo'] ) );
	}

	return $css;
}

add_filter( 'aheto_progress_bar_dynamic_css', 'karma_political_progress_bar_layout1_dynamic_css', 10, 2 );