<?php

use Aheto\Helper;

add_action('aheto_before_aheto_blockquote_register', 'ninedok_blockquote_layout1');

/**
 *  Banner Slider
 */

function ninedok_blockquote_layout1($shortcode)
{

    $preview_dir = '//assets.aheto.co/blockquote/previews/';

    $shortcode->add_layout('ninedok_layout1', [
        'title' => esc_html__('Blockquote 3', 'ninedok'),
        'image' => $preview_dir . 'ninedok_layout1.jpg',
    ]);

    $shortcode->add_dependecy('ninedok_modern_blockquote', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_bg_text', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_align', 'template', 'ninedok_layout1');
    $shortcode->add_dependecy('ninedok_modern_banners', 'template', 'ninedok_layout1');
	$shortcode->add_dependecy( 'ninedok_size', 'template', 'ninedok_layout1' );
	$shortcode->add_dependecy( 'ninedok_color', 'template', 'ninedok_layout1' );
    $shortcode->add_dependecy( 'ninedok_box_shadow_color', 'template', 'ninedok_layout1' );

	$shortcode->add_dependecy('ninedok_use_quote', 'template', 'ninedok_layout1');
	$shortcode->add_dependecy('ninedok_t_quote', 'template', 'ninedok_layout1');
	$shortcode->add_dependecy('ninedok_t_quote', 'ninedok_use_quote', 'true');

	$shortcode->add_dependecy('ninedok_use_banner_text', 'template', 'ninedok_layout1');
	$shortcode->add_dependecy('ninedok_t_banner_text', 'template', 'ninedok_layout1');
	$shortcode->add_dependecy('ninedok_t_banner_text', 'ninedok_use_banner_text', 'true');

    aheto_demos_add_dependency(['qoute_tag', 'use_author', 'quote_spacing','t_author' ], ['ninedok_layout1'], $shortcode);

    $shortcode->add_params([
        'ninedok_modern_blockquote' => [
            'type' => 'group',
            'heading' => esc_html__('Table Lists', 'ninedok'),
            'params' => [
                'ninedok_qoute' => [
                    'type' => 'textarea',
                    'heading' => esc_html__('Quote', 'ninedok'),
                ],
                'ninedok_date' => [
                    'type' => 'text',
                    'group' => 'Content',
                    'heading' => esc_html__('Date', 'ninedok'),
                ],
                'ninedok_author' => [
                    'type' => 'text',
                    'heading' => esc_html__('Author', 'ninedok'),
                    'grid' => 6,
                ],
            ],
        ],
        'ninedok_bg_text' => [
            'type' => 'text',
            'heading' => esc_html__('Background text', 'ninedok'),
            'default' => esc_html__('THEY SAY', 'ninedok'),
        ],
        'ninedok_use_quote' => [
            'type' => 'switch',
            'heading' => esc_html__('Use custom font for qoute?', 'ninedok'),
            'grid' => 6,
        ],
        'ninedok_t_quote' => [
            'type' => 'typography',
            'group' => 'Ninedok Qoute Typography',
            'settings' => [
                'tag' => false,
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-quote',
        ],
        'ninedok_align' => [
            'type' => 'select',
            'heading' => esc_html__('Align', 'ninedok'),
            'options' => Helper::choices_alignment(),
        ],
	    'ninedok_use_banner_text'  => [
		    'type'    => 'switch',
		    'heading' => esc_html__('Use custom font for background text?', 'ninedok'),
		    'grid'    => 6,
	    ],
	    'ninedok_t_banner_text'       => [
		    'type'     => 'typography',
		    'group'    => 'Ninedok Background Text Typography',
		    'settings' => [
			    'tag' => false,
			    'text_align' => false,
		    ],
		    'selector' => '{{WRAPPER}} .aheto-quote__bg-text',
	    ],
	    'ninedok_size'     => [
		    'type'      => 'text',
		    'heading'   => esc_html__( 'Size icon', 'ninedok' ),
		    'grid'      => 6,
		    'selectors' => [ '{{WRAPPER}} .aheto-quote:before' => 'font-size: {{VALUE}}px' ],
		    'description' => esc_html__( 'Set font size for icons. (Just write the number)', 'aheto' ),
	    ],
	    'ninedok_color'    => [
		    'type'      => 'colorpicker',
		    'heading'   => esc_html__( 'Color icon', 'ninedok' ),
		    'grid'      => 6,
		    'selectors' => [
			    '{{WRAPPER}} .aheto-quote:before' => 'color: {{VALUE}}'
		    ],
	    ],
        'ninedok_box_shadow_color'    => [
            'type'      => 'colorpicker',
            'heading'   => esc_html__( 'Color box-shadow', 'ninedok' ),
            'grid'      => 6,
            'selectors' => [
                '{{WRAPPER}} .aheto-quote--ninedok-simple' => 'box-shadow: 0 10px 50px 0 {{VALUE}}'
            ],
        ],
    ]);
}

function ninedok_blockquote_layout1_dynamic_css($css, $shortcode)
{

    if (!empty($shortcode->atts['ninedok_use_quote']) && !empty($shortcode->atts['ninedok_t_quote'])) {
        \aheto_add_props($css['global']['%1$s .aheto-quote'], $shortcode->parse_typography($shortcode->atts['ninedok_t_quote']));
    }
	if (!empty($shortcode->atts['ninedok_use_banner_text']) && !empty($shortcode->atts['ninedok_t_banner_text'])) {
		\aheto_add_props($css['global']['%1$s .aheto-quote__bg-text'], $shortcode->parse_typography($shortcode->atts['ninedok_t_banner_text']));
	}
	if ( ! empty( $shortcode->atts['ninedok_color'] ) ) {
		$color = Sanitize::color( $shortcode->atts['ninedok_color'] );
		$css['global']['%1$s .aheto-quote:before']['color'] = $color;
	}
	if ( ! empty( $shortcode->atts['ninedok_size'] ) ) {
		$size = Sanitize::size( $shortcode->atts['ninedok_size'] );
		$css['global']['%1$s .aheto-quote:before']['size'] = $size;
	}


	return $css;
}

add_filter('aheto_blockquote_dynamic_css', 'ninedok_blockquote_layout1_dynamic_css', 10, 2);