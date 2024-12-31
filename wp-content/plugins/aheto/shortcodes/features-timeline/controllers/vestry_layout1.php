<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-timeline_register', 'vestry_features_timeline_layout1');


/**
 * Features Timeline Shortcode
 */

function vestry_features_timeline_layout1($shortcode)
{
  $dir = '//assets.aheto.co/features-timeline/previews/';

  $shortcode->add_layout('vestry_layout1', [
    'title' => esc_html__('Features Timeline 7', 'vestry'),
    'image' => $dir . 'vestry_layout1.jpg',
  ]);

  $shortcode->add_dependecy('vestry_timeline', 'template', 'vestry_layout1');

  $shortcode->add_dependecy('vestry_use_date', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_date_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_date_typo', 'vestry_use_date', 'true');

  $shortcode->add_dependecy('vestry_use_heading', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_heading_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_heading_typo', 'vestry_use_heading', 'true');

  $shortcode->add_dependecy('vestry_use_description', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_description_typo', 'template', 'vestry_layout1');
  $shortcode->add_dependecy('vestry_description_typo', 'vestry_use_description', 'true');



  $shortcode->add_params([
    'vestry_timeline' => [
      'type'    => 'group',
      'heading' => esc_html__('Items', 'vestry'),
      'params'  => [
        'vestry_timeline_date'       => [
          'type'    => 'text',
          'heading' => esc_html__('Date in Timeline', 'vestry'),
        ],
        'vestry_article_date'          => [
          'type'        => 'textarea',
          'heading'     => esc_html__('Date in Article', 'vestry'),
          'default'     => esc_html__('march, 2020', 'vestry'),
        ],
        'vestry_timeline_title'        => [
          'type'    => 'textarea',
          'heading' => esc_html__('Title', 'vestry'),
          'description' => esc_html__('To Hightlight text insert text between: [[ Your Text Here ]]', 'vestry'),
          'default'     => esc_html__('Title with [[ hightlight ]] text.', 'vestry'),
        ],
        'vestry_timeline_content'        => [
          'type'    => 'textarea',
          'heading' => esc_html__('Content', 'vestry'),
          'default' => esc_html__('Add some text for content', 'vestry'),
        ],
        'vestry_timeline_image'     => [
          'type'    => 'attach_image',
          'heading' => esc_html__('Add image', 'vestry'),
        ],
      ],
    ],
    'vestry_use_date'     => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for date?', 'vestry'),
      'grid'    => 3,
    ],
    'vestry_use_heading'     => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for title?', 'vestry'),
      'grid'    => 3,
    ],
    'vestry_use_description' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for description?', 'vestry'),
      'grid'    => 3,
    ],
    'vestry_date_typo'     => [
      'type'     => 'typography',
      'group'    => 'Vestry Date Typography',
      'settings' => [
        'tag' => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-timeline__subtitle',
    ],
    'vestry_heading_typo'     => [
      'type'     => 'typography',
      'group'    => 'Vestry Title Typography',
      'settings' => [
        'tag' => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-timeline__title',
    ],
    'vestry_description_typo' => [
      'type'     => 'typography',
      'group'    => 'Vestry Description Typography',
      'settings' => [
        'tag' => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-timeline__desc',
    ],
  ]);
  \Aheto\Params::add_image_sizer_params($shortcode, [
    'prefix'         => 'vestry_',
    'dependency' => ['template',  ['vestry_layout1']]
  ]);
}

function vestry_features_timeline_layout1_dynamic_css( $css, $shortcode ) {

  if ( ! empty( $shortcode->atts['vestry_use_date'] ) && ! empty( $shortcode->atts['vestry_date_typo'] ) ) {
    \aheto_add_props( $css['global']['%1$s .aheto-timeline__subtitle'], $shortcode->parse_typography( $shortcode->atts['vestry_date_typo'] ) );
  }
  if ( ! empty( $shortcode->atts['vestry_use_heading'] ) && ! empty( $shortcode->atts['vestry_heading_typo'] ) ) {
    \aheto_add_props( $css['global']['%1$s .aheto-timeline__title'], $shortcode->parse_typography( $shortcode->atts['vestry_heading_typo'] ) );
  }
  if ( ! empty( $shortcode->atts['vestry_use_description'] ) && ! empty( $shortcode->atts['vestry_description_typo'] ) ) {
    \aheto_add_props( $css['global']['%1$s .aheto-timeline__title'], $shortcode->parse_typography( $shortcode->atts['vestry_description_typo'] ) );
  }
  
  return $css;
}

add_filter( 'aheto_features_timeline_dynamic_css', 'vestry_features_timeline_layout1_dynamic_css', 10, 2 );