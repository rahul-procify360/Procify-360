<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_heading_register', 'acacio_heading_layout1' );


/**
 * Heading
 */
function acacio_heading_layout1( $shortcode ) {

	$preview_dir = '//assets.aheto.co/heading/previews/';

	$shortcode->add_layout( 'acacio_layout2', [
		'title' => esc_html__( 'Heading 1', 'acacio' ),
		'image' => $preview_dir . 'acacio_layout2.jpg',
	] );

    aheto_demos_add_dependency( ['heading', 'text_typo', 'title_animation', 'alignment', 'text_tag', 'use_typo', 'text_typo_hightlight', 'use_typo_hightlight'], ['acacio_layout2'], $shortcode );

    // Acacio simple with highlighted text and another font
    $shortcode->add_dependecy( 'acacio_description', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_use_description_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_description_typo', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_description_typo', 'acacio_use_description_typo', 'true' );

    $shortcode->add_dependecy( 'acacio_use_add_image', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_image', 'acacio_use_add_image', 'true' );

    $shortcode->add_dependecy( 'acacio_highlighted_text', 'template', 'acacio_layout2' );
    $shortcode->add_dependecy( 'acacio_align_mobile', 'template', ['acacio_layout2'] );
    $shortcode->add_dependecy( 'acacio_image', 'template', ['acacio_layout2'] );


    $shortcode->add_params( [
        'acacio_description'   => [
            'type'        => 'textarea',
            'heading'     => esc_html__( 'Description', 'acacio' ),
            'description' => esc_html__( 'Add some text for description', 'acacio' ),
            'admin_label' => true,
            'default'     => esc_html__( 'Add some text for description', 'acacio' ),
        ],
        'acacio_use_description_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for description?', 'acacio' ),
            'grid'    => 3,
        ],

        'acacio_description_typo' => [
            'type'     => 'typography',
            'group'    => 'Description Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-heading__desc',
        ],
        'acacio_highlighted_text' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Disable secondary text highlighting?', 'acacio' ),
            'grid'    => 12,
        ],
        'acacio_align_mobile' => [
            'type'    => 'select',
            'heading' => esc_html__( 'Align for mobile', 'acacio' ),
            'options' => [
                'default' => 'Default',
                'left'    => 'Left',
                'center'  => 'Center',
                'right'   => 'Right',
            ],
            'default' => 'default',
        ],
        'acacio_use_add_image' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use illustration?', 'acacio' ),
            'grid'    => 3,
        ],
        'acacio_image'         => [
            'type'    => 'attach_image',
            'heading' => esc_html__( 'Add illustration', 'acacio' ),
        ],

    ] );

    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group'      => esc_html__( 'Images size for illustration ', 'acacio' ),
        'prefix'     => 'acacio_',
        'dependency' => ['template', [ 'acacio_layout2'] ]
    ]);

}

function acacio_heading_layout1_dynamic_css( $css, $shortcode ) {
    if ( ! empty( $shortcode->atts['acacio_use_description_typo'] ) && ! empty( $shortcode->atts['acacio_description_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-heading__desc'], $shortcode->parse_typography( $shortcode->atts['acacio_description_typo'] ) );
    }

	return $css;
}

add_filter( 'aheto_heading_dynamic_css', 'acacio_heading_layout1_dynamic_css', 10, 2 );

