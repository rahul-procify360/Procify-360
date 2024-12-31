<?php

use Aheto\Helper;
add_action( 'aheto_before_aheto_progress-bar_register', 'prego_progress_bar_layout1' );
/**
 * Progress Bar Shortcode
 */

function prego_progress_bar_layout1( $shortcode ) {

    $preview_dir = '//assets.aheto.co/progress-bar/previews/';

	$shortcode->add_layout( 'prego_layout1', [
		'title' => esc_html__( 'Prego Circles', 'prego' ),
		'image' => $preview_dir . 'prego_layout1.jpg',
	] );


    aheto_demos_add_dependency( ['percentage', 'heading', 'description'], [ 'prego_layout1' ], $shortcode );

    //	Prego Inline Progress Bar
    $shortcode->add_dependecy( 'prego_line_color', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_active_color', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_use_text_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_text_typo', 'template', 'prego_layout1' );
    $shortcode->add_dependecy( 'prego_text_typo', 'prego_use_text_typo', 'true' );

    $shortcode->add_dependecy('prego_add_chart_symbol_use_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_add_chart_symbol_typo', 'template', 'prego_layout1');
    $shortcode->add_dependecy('prego_add_chart_symbol_typo', 'prego_add_chart_symbol_use_typo', 'true');


    $shortcode->add_params([
        'prego_use_text_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for heading?', 'prego' ),
            'grid'    => 3,
        ],
        'prego_text_typo' => [
            'type'     => 'typography',
            'group'    => 'Prego Heading Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => true,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title, {{WRAPPER}} .aheto-progress__bar-perc',
        ],
        'prego_line_color'   => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Line color', 'prego' ),
            'grid'      => 6,
            'default'   => '#FFE7ED',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__chart-bg' => 'stroke: {{VALUE}}',
            ],
        ],
        'prego_active_color' => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Active line color', 'prego' ),
            'grid'      => 6,
            'default'   => '#FF3366',
            'selectors' => [
                '{{WRAPPER}} .aheto-progress__chart-circle' => 'stroke: {{VALUE}}',
            ],
        ],
        'prego_add_chart_symbol_use_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__('Use custom font for title?', 'prego'),
            'grid'    => 3,
        ],
        'prego_add_chart_symbol_typo'     => [
            'type'     => 'typography',
            'group'    => 'Prego Title Typography',
            'settings' => [
                'tag'        => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-progress__title',
        ],
    ]);
}
