<?php

add_action( 'aheto_before_aheto_banner-slider_register', 'snapster_banner_slider_layout3_shortcode' );

/**
 * Banner Slider shortcode
 */
function snapster_banner_slider_layout3_shortcode($shortcode){

	$preview_dir = '//assets.aheto.co/banner-slider/previews/';

    $shortcode->add_layout('snapster_layout3', [
        'title' => esc_html__('Banner Slider 26', 'snapster'),
        'image' => $preview_dir . 'snapster_layout3.jpg',
    ]);

    $shortcode->add_dependecy('snapster_modern_banners', 'template', 'snapster_layout3');

    $shortcode->add_dependecy('snapster_use_subtitle_typo', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy('snapster_subtitle_typo', 'snapster_use_subtitle_typo', 'true' );

    $shortcode->add_dependecy('snapster_use_title_typo', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy('snapster_title_typo', 'snapster_use_title_typo', 'true' );

    $shortcode->add_dependecy('snapster_use_buttons_typo', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy('snapster_buttons_typo', 'snapster_use_buttons_typo', 'true' );

    $shortcode->add_dependecy('snapster_use_pagination_typo', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy('snapster_pagination_typo', 'snapster_use_pagination_typo', 'true' );

    $shortcode->add_dependecy( 'snapster_slider_pagination', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_slider_buttons', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_slider_animation', 'template', 'snapster_layout3' );

    $shortcode->add_dependecy( 'snapster_dark_arrows', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_dark_arrows', 'snapster_slider_buttons', '' );

    $shortcode->add_dependecy( 'snapster_wider_buttons', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_wider_buttons', 'snapster_slider_buttons', '' );

    $shortcode->add_dependecy( 'snapster_prev_button', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_prev_button', 'snapster_slider_buttons', '' );

    $shortcode->add_dependecy( 'snapster_next_button', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_next_button', 'snapster_slider_buttons', '' );

    $shortcode->add_dependecy( 'snapster_slider_loop', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_slider_autoplay', 'template', 'snapster_layout3' );

    $shortcode->add_dependecy( 'snapster_slider_autoplay_speed', 'template', 'snapster_layout3' );
    $shortcode->add_dependecy( 'snapster_slider_autoplay_speed', 'snapster_slider_autoplay', 'true' );

    $shortcode->add_params([
        'snapster_modern_banners' => [
            'type'    => 'group',
            'heading' => esc_html__( 'Snapster Banners', 'snapster' ),
            'params'  => [
                'snapster_ban_title'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Title', 'snapster' ),
                    'default'    => 'Slide title',
                ],
                'snapster_image'         => [
                    'type'    => 'attach_image',
                    'heading' => esc_html__( 'Background Image', 'snapster' ),
                ],
                'snapster_subtitle'          => [
                    'type'    => 'text',
                    'heading' => esc_html__( 'Subtitle', 'snapster' ),
                    'default'    => 'Slide subtitle',
                ],
            ]
        ],
        'snapster_use_subtitle_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Subtitle?', 'snapster' ),
            'grid'    => 3,
        ],
        'snapster_subtitle_typo' => [
            'type'     => 'typography',
            'group'    => 'Snapster Subtitle Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__text .subtitle',
        ],
        'snapster_use_title_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Title?', 'snapster' ),
            'grid'    => 3,
        ],
        'snapster_title_typo' => [
            'type'     => 'typography',
            'group'    => 'Snapster Title Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__text .title',
        ],
        'snapster_use_buttons_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Prev & Next Buttons?', 'snapster' ),
            'grid'    => 3,
        ],
        'snapster_buttons_typo' => [
            'type'     => 'typography',
            'group'    => 'Snapster Prev & Next Buttons Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__buttons-prev span::before, {{WRAPPER}} .aheto-banner-slider__buttons-next span::before',
        ],
        'snapster_use_pagination_typo' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use custom font for Pagination?', 'snapster' ),
            'grid'    => 3,
        ],
        'snapster_pagination_typo' => [
            'type'     => 'typography',
            'group'    => 'Snapster Pagination Typography',
            'settings' => [
                'text_align' => false,
            ],
            'selector' => '{{WRAPPER}} .aheto-banner-slider__pagination--counters label',
        ],
        'snapster_slider_loop' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable Loop?', 'snapster' ),
            'grid'    => 3,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_slider_autoplay' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Enable Autoplay?', 'snapster' ),
            'grid'    => 3,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_slider_autoplay_speed' => [
            'type'    => 'text',
            'heading' => esc_html__( 'Autoplay speed', 'snapster' ),
            'description' => esc_html__( 'In seconds. Please, write only number.', 'aheto' ),
            'default'    => '',
            'grid'    => 3,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_slider_animation' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Disable animation for Title?', 'snapster' ),
            'grid'    => 3,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_slider_pagination' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Hide Pagination?', 'snapster' ),
            'grid'    => 3,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_slider_buttons' => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Hide Buttons?', 'snapster' ),
            'grid'    => 3,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_prev_button'          => [
            'type'    => 'text',
            'heading' => esc_html__( 'Text for Previous Button', 'snapster' ),
            'default'    => 'PREV PROJECT',
            'label_block' => true,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_next_button'          => [
            'type'    => 'text',
            'heading' => esc_html__( 'Text for Next Button', 'snapster' ),
            'default'    => 'NEXT PROJECT',
            'label_block' => true,
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_dark_arrows'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use dark theme for navigation buttons?', 'snapster' ),
            'grid'    => 12,
            'default' => '',
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
        'snapster_wider_buttons'   => [
            'type'    => 'switch',
            'heading' => esc_html__( 'Use wider navigation buttons?', 'snapster' ),
            'grid'    => 12,
            'default' => '',
            'group' => esc_html__( 'Snapster Slider Options', 'snapster' ),
        ],
    ]);


    \Aheto\Params::add_button_params( $shortcode, [
        'add_button' => true,
        'prefix' => 'snapster_main_',
    ], 'snapster_modern_banners' );


    \Aheto\Params::add_image_sizer_params($shortcode, [
        'group' => esc_html__( 'Snapster images size', 'snapster' ),
        'prefix' => 'snapster_',
        'dependency' => ['template', 'snapster_layout3']
    ]);
}

function snapster_banner_slider_shortcode_layout3_dynamic_css($css, $shortcode)
{
    if ( ! empty( $shortcode->atts['snapster_use_subtitle_typo'] ) && ! empty( $shortcode->atts['snapster_subtitle_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-banner-slider__sub-title'], $shortcode->parse_typography( $shortcode->atts['snapster_subtitle_typo'] ) );
    }
    if ( ! empty( $shortcode->atts['snapster_use_title_typo'] ) && ! empty( $shortcode->atts['snapster_title_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-banner-slider__title'], $shortcode->parse_typography( $shortcode->atts['snapster_title_typo'] ) );
    }
    return $css;
}
add_filter('aheto_banner_slider_dynamic_css', 'snapster_banner_slider_shortcode_layout3_dynamic_css', 10, 2);