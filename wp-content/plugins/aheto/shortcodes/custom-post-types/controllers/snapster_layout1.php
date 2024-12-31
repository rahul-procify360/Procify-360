<?php

add_action('aheto_before_aheto_custom-post-types_register', 'snapster_custom_post_types_layout1_shortcode');

/**
 * Banner Slider shortcode
 */
function snapster_custom_post_types_layout1_shortcode($shortcode){
    $dir = '//assets.aheto.co/custom-post-types/previews/';

    $shortcode->add_layout('snapster_layout1', [
        'title' => esc_html__('Snapster Slider Thumbnails', 'snapster'),
        'image' => $dir . 'snapster_layout1.jpg',
    ]);

    aheto_demos_add_dependency( ['use_heading', 't_heading', 'use_term', 't_term', 'title_tag'], [ 'snapster_layout1' ], $shortcode );

    $shortcode->add_dependecy('snapster_icon_color', 'template', 'snapster_layout1');
    $shortcode->add_dependecy('snapster_overlay_color', 'template', 'snapster_layout1');
    $shortcode->add_dependecy('snapster_view_more_btn', 'template', 'snapster_layout1');
    $shortcode->add_dependecy('snapster_use_view_more_btn_typo', 'template', 'snapster_layout1');
    $shortcode->add_dependecy('snapster_view_more_btn_typo', 'template', 'snapster_layout1');
    $shortcode->add_dependecy('snapster_view_more_btn_typo', 'snapster_use_view_more_btn_typo', 'true');

    $shortcode->add_params([
	    'snapster_overlay_color' => [
		    'type' => 'colorpicker',
		    'heading' => esc_html__ ( 'Overlay color', 'aheto' ),
		    'grid' => 6,
		    'selectors' => [ '{{WRAPPER}} .swiper-bottom .swiper-container .swiper-wrapper .swiper-slide-thumb-active, {{WRAPPER}} .swiper-bottom .swiper-container .swiper-wrapper>.swiper-slide:hover' => 'box-shadow: inset 0 0 200px {{VALUE}}' ],
	    ],
	    'snapster_icon_color' => [
		    'type' => 'colorpicker',
		    'heading' => esc_html__ ( 'Icon color', 'aheto' ),
		    'grid' => 6,
		    'selectors' => [ '{{WRAPPER}} .swiper-bottom .thumbs_switcher_wrap i' => 'color: {{VALUE}}' ],
	    ],
        'snapster_view_more_btn' => [
            'type' => 'text',
            'heading' => esc_html__('Text for View More Button', 'aheto'),
            'grid' => 9,
            'admin_label' => true,
            'label_block'       => true,
            'default' => esc_html__('View Project', 'aheto'),
        ],
        'snapster_use_view_more_btn_typo' => [
            'type'    => 'switch',
            'label_block'       => true,
            'heading' => esc_html__( 'Use custom font for View More Button?', 'aheto' ),
            'grid'    => 3,
        ],
        'snapster_view_more_btn_typo' => [
            'type'     => 'typography',
            'group'    => 'Snapster Button Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-cpt--btn',
        ],
    ]);

    \Aheto\Params::add_carousel_params($shortcode, [
        'custom_options' => true,
        'prefix' => 'snapster_swiper_',
        'include' => ['speed', 'autoplay', 'arrows', 'lazy', 'slides', 'arrows_size', 'arrows_color'],
        'dependency' => ['template', 'snapster_layout1']
    ]);
}

function snapster_custom_post_types_shortcode_layout1_dynamic_css($css, $shortcode){
    if (!empty($shortcode->atts['snapster_use_view_more_btn_typo']) && !empty($shortcode->atts['snapster_view_more_btn_typo'])) {
        \aheto_add_props($css['global']['%1$s .aheto-cpt--btn'], $shortcode->parse_typography($shortcode->atts['snapster_view_more_btn_typo']));
    }
    return $css;
}

add_filter('aheto_cpt_dynamic_css', 'snapster_custom_post_types_shortcode_layout1_dynamic_css', 10, 2);
