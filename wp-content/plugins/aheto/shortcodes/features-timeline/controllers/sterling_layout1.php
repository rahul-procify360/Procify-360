<?php

use Aheto\Helper;

add_action('aheto_before_aheto_features-timeline_register', 'sterling_features_timeline_layout1');


/**
 * Features Timeline Shortcode
 */

function sterling_features_timeline_layout1($shortcode)
{
  $dir = '//assets.aheto.co/features-timeline/previews/';

  $shortcode->add_layout('sterling_layout1', [
    'title' => esc_html__('Sterling Modern', 'sterling'),
    'image' => $dir . 'sterling_layout1.jpg',
  ]);

  $shortcode->add_dependecy('sterling_timeline', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_arrow_size', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_use_heading', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_use_description', 'template', 'sterling_layout1');
  $shortcode->add_dependecy('sterling_heading_typo', 'sterling_use_heading', 'true');
  $shortcode->add_dependecy('sterling_description_typo', 'sterling_use_description', 'true');


  $shortcode->add_params([
    'sterling_timeline' => [
      'type' => 'group',
      'heading' => esc_html__('Items', 'sterling'),
      'params' => [
        'sterling_timeline_date' => [
          'type' => 'text',
          'heading' => esc_html__('Date', 'sterling'),
        ],
        'sterling_timeline_title' => [
          'type' => 'textarea',
          'heading' => esc_html__('Title', 'sterling'),
          'description' => esc_html__('To Hightlight text insert text between: [[ Your Text Here ]]', 'sterling'),
          'default' => esc_html__('Title with [[ hightlight ]] text.', 'sterling'),
        ],
        'sterling_timeline_content' => [
          'type' => 'textarea',
          'heading' => esc_html__('Content', 'sterling'),
          'default' => esc_html__('Add some text for content', 'sterling'),
        ],
        'sterling_timeline_image' => [
          'type' => 'attach_image',
          'heading' => esc_html__('Add image', 'sterling'),
        ],
      ],
    ],
    'sterling_arrow_size' => [
      'type'    => 'text',
      'heading' => esc_html__('Arrow size', 'sterling'),
      'description' => esc_html__('Enter arrow font size with units.', 'sterling'),
      'grid'        => 6,
      'selectors' => ['{{WRAPPER}} .aheto-timeline__navigation a' => 'font-size: {{VALUE}}'],
    ],
    'sterling_use_heading'     => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Article Title?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_heading_typo'     => [
      'type'     => 'typography',
      'group'    => 'Heading Typography',
      'settings' => [
        'tag' => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-timeline__title',
    ],
    'sterling_use_description' => [
      'type'    => 'switch',
      'heading' => esc_html__('Use custom font for Description?', 'sterling'),
      'grid'    => 3,
    ],
    'sterling_description_typo' => [
      'type'     => 'typography',
      'group'    => 'Description Typography',
      'settings' => [
        'tag' => false,
        'text_align' => true,
      ],
      'selector' => '{{WRAPPER}} .aheto-timeline__desc',
    ],
  ]);

  \Aheto\Params::add_button_params($shortcode, [
    'prefix' => 'sterling_',
    'icons' => true,
  ], 'sterling_timeline');

  \Aheto\Params::add_image_sizer_params($shortcode, [
    'prefix' => 'sterling_',
    'dependency' => ['template', ['sterling_layout1']]
  ]);
}

function sterling_features_timeline_layout1_dynamic_css($css, $shortcode)
{
  if ( ! empty( $shortcode->atts['sterling_use_heading'] ) && ! empty( $shortcode->atts['sterling_heading_typo'] ) ) {
    \aheto_add_props( $css['global']['%1$s .aheto-timeline__title'], $shortcode->parse_typography( $shortcode->atts['sterling_heading_typo'] ) );
  }
  if ( ! empty( $shortcode->atts['sterling_use_description'] ) && ! empty( $shortcode->atts['sterling_description_typo'] ) ) {
    \aheto_add_props( $css['global']['%1$s .aheto-timeline__desc'], $shortcode->parse_typography( $shortcode->atts['sterling_description_typo'] ) );
  }
  if (!empty($shortcode->atts['sterling_arrow_size'])) {
    $css['global']['%1$s .aheto-timeline__navigation a']['font-size'] = Sanitize::size($shortcode->atts['sterling_arrow_size']);
  }

  return $css;
}

add_filter('aheto_features_timeline_dynamic_css', 'sterling_features_timeline_layout1_dynamic_css', 10, 2);
