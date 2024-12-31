<?php

use Aheto\Helper;

add_action('aheto_before_aheto_testimonials_register', 'karma_travel_testimonials_layout2');

/**
 * Testimonials
 */

function karma_travel_testimonials_layout2($shortcode)
{

	$preview_dir = '//assets.aheto.co/testimonials/previews/';

  $shortcode->add_layout('karma_travel_layout2', [
    'title' => esc_html__('Karma Travel Modern', 'karma'),
    'image' => $preview_dir . 'karma_travel_layout2.jpg',
  ]);

  $shortcode->add_dependecy('karma_travel_testimonials', 'template', ['karma_travel_layout2']);

  $shortcode->add_dependecy('karma_travel_use_quote_typo', 'template', 'karma_travel_layout2');
  $shortcode->add_dependecy('karma_travel_quote_typo', 'template', 'karma_travel_layout2');
  $shortcode->add_dependecy('karma_travel_quote_typo', 'karma_travel_use_quote_typo', 'true');

  $shortcode->add_dependecy('karma_travel_name_use_typo', 'template', 'karma_travel_layout2');
  $shortcode->add_dependecy('karma_travel_name_typo', 'template', 'karma_travel_layout2');
  $shortcode->add_dependecy('karma_travel_name_typo', 'karma_travel_name_use_typo', 'true');

  $shortcode->add_dependecy('karma_travel_pos_use_typo', 'template', 'karma_travel_layout2');
  $shortcode->add_dependecy('karma_travel_pos_typo', 'template', 'karma_travel_layout2');
  $shortcode->add_dependecy('karma_travel_pos_typo', 'karma_travel_pos_use_typo', 'true');

  $shortcode->add_params([
    'karma_travel_testimonials' => [
      'type'    => 'group',
      'heading' => esc_html__('Modern Testimonials Items', 'karma'),
      'params'  => [
        'karma_travel_image'       => [
          'type'    => 'attach_image',
          'heading' => esc_html__('Display Image', 'karma'),
        ],
        'karma_travel_name'        => [
          'type'    => 'text',
          'heading' => esc_html__('Name', 'karma'),
          'default' => esc_html__('Author name', 'karma'),
        ],
        'karma_travel_company'     => [
          'type'    => 'text',
          'heading' => esc_html__('Position', 'karma'),
          'default' => esc_html__('Author position', 'karma'),
        ],
        'karma_travel_testimonial' => [
          'type'    => 'textarea',
          'heading' => esc_html__('Testimonial', 'karma'),
          'default' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'karma'),
        ],
      ],
    ],
    'karma_travel_use_quote_typo' => [
      'type' => 'switch',
      'heading' => esc_html__('Use custom font for karma testimonials?', 'karma'),
      'grid' => 12,
      'default' => '',
    ],
    'karma_travel_quote_typo' => [
        'type' => 'typography',
        'group' => 'Karma Travel Testimonials Typography',
        'settings' => [
          'text_align' => false,
        ],
        'selector' => '{{WRAPPER}} .aheto-tm__text',
    ],
    'karma_travel_name_use_typo'            => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for karma name?', 'karma'),
      'grid'    => 3,
    ],
    'karma_travel_name_typo'                => [
      'type'     => 'typography',
      'group'    => 'Karma Travel Name Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__name',
    ],
    'karma_travel_pos_use_typo'            => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for karma position?', 'karma'),
      'grid'    => 3,
    ],
    'karma_travel_pos_typo'                => [
      'type'     => 'typography',
      'group'    => 'Karma Travel Position Typography',
      'settings' => [
        'tag'        => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-tm__position',
    ],
  ]);


  \Aheto\Params::add_carousel_params($shortcode, [
    'custom_options' => true,
    'include'        => [ 'pagination', 'loop', 'autoplay', 'speed', 'slides', 'spaces', 'simulate_touch'],
    'prefix'         => 'karma_travel_swiper_',
    'dependency'     => ['template', ['karma_travel_layout2']]
  ]);
	\Aheto\Params::add_networks_params($shortcode, [
		'prefix' => 'karma_travel_',
	], 'karma_travel_testimonials');
}

function karma_travel_testimonials_layout2_dynamic_css($css, $shortcode) {

  if ( !empty($shortcode->atts['karma_travel_use_quote_typo']) && !empty($shortcode->atts['karma_travel_quote_typo']) ) {
    \aheto_add_props($css['global']['%1$s .aheto-tm__text'], $shortcode->parse_typography($shortcode->atts['karma_travel_quote_typo']));
  }
  if ( !empty($shortcode->atts['karma_travel_pos_use_typo']) && !empty($shortcode->atts['karma_travel_pos_typo']) ) {
    \aheto_add_props($css['global']['%1$s .aheto-tm__position'], $shortcode->parse_typography($shortcode->atts['karma_travel_pos_typo']));
  }
  if ( !empty($shortcode->atts['karma_travel_name_use_typo']) && !empty($shortcode->atts['karma_travel_name_typo']) ) {
    \aheto_add_props($css['global']['%1$s .aheto-tm__name'], $shortcode->parse_typography($shortcode->atts['karma_travel_name_typo']));
  }
  return $css;
}
add_filter( 'aheto_testimonials_dynamic_css', 'karma_travel_testimonials_layout2_dynamic_css', 10, 2 );
