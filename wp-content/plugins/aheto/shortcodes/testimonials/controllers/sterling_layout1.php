<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'sterling_testimonials_layout1');

/**
 * Testimonials Shortcode
 */

function sterling_testimonials_layout1($shortcode)
{
  $theme_dir = '//assets.aheto.co/testimonials/previews/';
  $shortcode->add_layout('sterling_layout1', [
    'title' => esc_html__('Sterling Classic', 'sterling'),
    'image' => $theme_dir . 'sterling_layout1.jpg',
  ]);

  $shortcode->add_dependecy('sterling_testimonials', 'template', ['sterling_layout1']);
  $shortcode->add_dependecy('sterling_use_quote_typo', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_quote_typo', 'sterling_use_quote_typo', 'true');
  $shortcode->add_dependecy('sterling_name_use_typo', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_name_typo', 'sterling_name_use_typo', 'true');
  $shortcode->add_dependecy('sterling_pos_use_typo', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_pos_typo', 'sterling_pos_use_typo', 'true');

  $shortcode->add_params([
    'sterling_testimonials' => [
      'type'    => 'group',
      'heading' => esc_html__('Modern Testimonials Items', 'sterling'),
      'params'  => [
        'sterling_image'       => [
          'type'    => 'attach_image',
          'heading' => esc_html__('Display Image', 'sterling'),
        ],
        'sterling_title'        => [
          'type'    => 'text',
          'heading' => esc_html__('Title', 'sterling'),
          'default' => esc_html__('Title', 'sterling'),
        ],
        'sterling_rating'      => [
          'type'    => 'select',
          'heading' => esc_html__('Rating', 'sterling'),
          'options' => [
            '1'   => esc_html__('1', 'sterling'),
            '1.5' => esc_html__('1.5', 'sterling'),
            '2'   => esc_html__('2', 'sterling'),
            '2.5' => esc_html__('2.5', 'sterling'),
            '3'   => esc_html__('3', 'sterling'),
            '3.5' => esc_html__('3.5', 'sterling'),
            '4'   => esc_html__('4', 'sterling'),
            '4.5' => esc_html__('4.5', 'sterling'),
            '5'   => esc_html__('5', 'sterling'),
          ],
          'default' => '5',
        ],
        'sterling_name'        => [
          'type'    => 'text',
          'heading' => esc_html__('Name', 'sterling'),
          'default' => esc_html__('Author name', 'sterling'),
        ],
        'sterling_company'     => [
          'type'    => 'text',
          'heading' => esc_html__('Position', 'sterling'),
          'default' => esc_html__('Author position', 'sterling'),
        ],
        'sterling_testimonial' => [
          'type'    => 'textarea',
          'heading' => esc_html__('Testimonial', 'sterling'),
          'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'sterling'),
        ],
      ],
    ],
    'sterling_use_quote_typo' => [
      'type' => 'switch',
      'heading' => esc_html__('Use custom font for Quote?', 'sterling'),
      'grid' => 12,
      'default' => '',
    ],
    'sterling_quote_typo' => [
      'type' => 'typography',
      'group' => 'Quote Typography',
      'settings' => [
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__title-wrap:after',
    ],
    'sterling_name_use_typo'            => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Name?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_name_typo'                => [
      'type'     => 'typography',
      'group'    => 'Name Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => false,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__name',
    ],
    'sterling_pos_use_typo'            => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Position?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_pos_typo'                => [
      'type'     => 'typography',
      'group'    => 'Position Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__position',
    ],
  ]);

  \Aheto\Params::add_carousel_params($shortcode, [
    'custom_options' => true,
    'include'        => ['arrows','arrows_color', 'arrows_size', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
    'prefix'         => 'sterling_swiper_',
    'dependency'     => ['template', ['sterling_layout1']]
  ]);
}
