<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'ewo_testimonials_layout1');

/**
 * Testimonials
 */

function ewo_testimonials_layout1($shortcode)
{

  $preview_dir = '//assets.aheto.co/testimonials/previews/';

  $shortcode->add_layout('ewo_layout1', [
    'title' => esc_html__('Testimonials 4', 'ewo'),
    'image' => $preview_dir . 'ewo_layout1.jpg',
  ]);

  $shortcode->add_dependecy('ewo_testimonials_creative_item', 'template', 'ewo_layout1');

  $shortcode->add_dependecy('ewo_use_name_typo', 'template', 'ewo_layout1');
  $shortcode->add_dependecy('ewo_name_typo', 'template', 'ewo_layout1');
  $shortcode->add_dependecy('ewo_name_typo', 'ewo_use_name_typo', 'true');

  $shortcode->add_params([
    'ewo_testimonials_creative_item' => [
      'type'    => 'group',
      'heading' => esc_html__('Modern Testimonials Items', 'ewo'),
      'params'  => [
        'ewo_image'       => [
          'type'    => 'attach_image',
          'heading' => esc_html__('Display Image', 'ewo'),
        ],
        'ewo_name'        => [
          'type'    => 'text',
          'heading' => esc_html__('Name', 'ewo'),
          'default' => esc_html__('Author name', 'ewo'),
        ],
        'ewo_testimonial' => [
          'type'    => 'textarea',
          'heading' => esc_html__('Testimonial', 'ewo'),
          'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'ewo'),
        ],
      ],
    ],
    'ewo_use_name_typo' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for name?', 'ewo'),
      'grid'    => 3,
    ],

    'ewo_name_typo' => [
      'type'     => 'typography',
      'group'    => 'Ewo Name Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__name',
    ],
  ]);


  \Aheto\Params::add_carousel_params($shortcode, [
    'custom_options' => true,
    'include'        => ['loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
    'prefix'         => 'ewo_swiper_',
    'dependency'     => ['template', ['ewo_layout1']]
  ]);

  \Aheto\Params::add_image_sizer_params($shortcode, [
    'prefix' => 'ewo_',
    'dependency' => ['template', ['ewo_layout1']]
  ]);
}

function ewo_testimonials_layout1_dynamic_css( $css, $shortcode ) {

    if ( ! empty( $shortcode->atts['ewo_use_name_typo'] ) && ! empty( $shortcode->atts['ewo_name_typo'] ) ) {
        \aheto_add_props( $css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography( $shortcode->atts['ewo_name_typo'] ) );
    }

    return $css;
}

add_filter( 'aheto_testimonials_dynamic_css', 'ewo_testimonials_layout1_dynamic_css', 10, 2 );
