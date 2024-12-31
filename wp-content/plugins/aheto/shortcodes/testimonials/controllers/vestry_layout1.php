<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'vestry_testimonials_layout1');

/**
 * Testimonials
 */

function vestry_testimonials_layout1($shortcode)
{

  $preview_dir = '//assets.aheto.co/testimonials/previews/';

  $shortcode->add_layout('vestry_layout1', [
    'title' => esc_html__('Testimonials 27', 'vestry'),
    'image' => $preview_dir . 'vestry_layout1.jpg',
  ]);

  $shortcode->add_dependecy('vestry_testimonials', 'template', ['vestry_layout1']);

  $shortcode->add_dependecy('vestry_use_quote_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_quote_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_quote_typo', 'vestry_use_quote_typo', 'true');

  $shortcode->add_dependecy('vestry_name_use_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_name_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_name_typo', 'vestry_name_use_typo', 'true');

  $shortcode->add_dependecy('vestry_pos_use_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_pos_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_pos_typo', 'vestry_pos_use_typo', 'true');

  $shortcode->add_params([
    'vestry_testimonials' => [
      'type'    => 'group',
      'heading' => esc_html__('Modern Testimonials Items', 'vestry'),
      'params'  => [
        'vestry_image'       => [
          'type'    => 'attach_image',
          'heading' => esc_html__('Display Image', 'vestry'),
        ],
        'vestry_title'        => [
          'type'    => 'text',
          'heading' => esc_html__('Title', 'vestry'),
          'default' => esc_html__('Title', 'vestry'),
        ],
        'vestry_rating'      => [
          'type'    => 'select',
          'heading' => esc_html__('Rating', 'vestry'),
          'options' => [
            '1'   => esc_html__('1', 'vestry'),
            '1.5' => esc_html__('1.5', 'vestry'),
            '2'   => esc_html__('2', 'vestry'),
            '2.5' => esc_html__('2.5', 'vestry'),
            '3'   => esc_html__('3', 'vestry'),
            '3.5' => esc_html__('3.5', 'vestry'),
            '4'   => esc_html__('4', 'vestry'),
            '4.5' => esc_html__('4.5', 'vestry'),
            '5'   => esc_html__('5', 'vestry'),
          ],
          'default' => '5',
        ],
        'vestry_name'        => [
          'type'    => 'text',
          'heading' => esc_html__('Name', 'vestry'),
          'default' => esc_html__('Author name', 'vestry'),
        ],
        'vestry_company'     => [
          'type'    => 'text',
          'heading' => esc_html__('Position', 'vestry'),
          'default' => esc_html__('Author position', 'vestry'),
        ],
        'vestry_testimonial' => [
          'type'    => 'textarea',
          'heading' => esc_html__('Testimonial', 'vestry'),
          'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'vestry'),
        ],
      ],
    ],
    'vestry_use_quote_typo' => [
      'type' => 'switch',
      'heading' => esc_html__('Use custom font for testimonials?', 'vestry'),
      'grid' => 12,
      'default' => '',
    ],
    'vestry_quote_typo' => [
        'type' => 'typography',
        'group' => 'Vestry Testimonials Typography',
        'settings' => [
          'text_align' => false,
        ],
        'selector' => '{{WRAPPER}} .aheto-tm__title-wrap:after',
    ],
    'vestry_name_use_typo'            => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for name?', 'vestry'),
      'grid'    => 3,
    ],
    'vestry_name_typo'                => [
      'type'     => 'typography',
      'group'    => 'Vestry Name Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__name',
    ],
    'vestry_pos_use_typo'            => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for position?', 'vestry'),
      'grid'    => 3,
    ],
    'vestry_pos_typo'                => [
      'type'     => 'typography',
      'group'    => 'Vestry Position Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__position',
    ],
  ]);


  \Aheto\Params::add_carousel_params($shortcode, [
    'custom_options' => true,
    'include'        => ['arrows', 'pagination', 'arrows_color', 'arrows_size', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
    'prefix'         => 'vestry_swiper_',
    'dependency'     => ['template', ['vestry_layout1']]
  ]);
  \Aheto\Params::add_image_sizer_params($shortcode, [
    'prefix' => 'vestry_',
    'dependency' => ['template', ['vestry_layout1']]
  ]);
}

function vestry_testimonials_layout1_dynamic_css($css, $shortcode) {

  if ( !empty($shortcode->atts['vestry_use_quote_typo']) && !empty($shortcode->atts['vestry_quote_typo']) ) {
    \aheto_add_props($css['global']['%1$s .aheto-tm__title-wrap:after'], $shortcode->parse_typography($shortcode->atts['vestry_quote_typo']));
  }
  if ( !empty($shortcode->atts['vestry_pos_use_typo']) && !empty($shortcode->atts['vestry_pos_typo']) ) {
    \aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['vestry_pos_typo']));
  }
  if ( !empty($shortcode->atts['vestry_name_use_typo']) && !empty($shortcode->atts['vestry_name_typo']) ) {
    \aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['vestry_name_typo']));
  }
  return $css;
}

add_filter('famulus_testimonials_dynamic_css', 'муіекн_testimonials_layout1_dynamic_css', 10, 2);